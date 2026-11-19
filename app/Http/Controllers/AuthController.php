<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if ($request->session()->has('auth')) {
            return $this->redirectByRole($request->session()->get('auth.role'));
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $accounts = [
            ['table' => 'super_admin', 'id_column' => 'id_super_admin', 'role' => 'super_admin'],
            ['table' => 'admin_kampus', 'id_column' => 'id_admin', 'role' => 'admin_kampus'],
            ['table' => 'satpam', 'id_column' => 'id_satpam', 'role' => 'satpam'],
            ['table' => 'pelapor_kehilangan', 'id_column' => 'id_pelapor', 'role' => 'pelapor'],
        ];

        $matchedAccount = null;
        foreach ($accounts as $account) {
            $user = DB::table($account['table'])->where('email', $credentials['email'])->first();
            if ($user) {
                if ($matchedAccount !== null) {
                    return back()->withErrors(['email' => 'Email terdaftar pada lebih dari satu akun.'])->onlyInput('email');
                }
                $matchedAccount = [
                    'id' => $user->{$account['id_column']},
                    'role' => $account['role'],
                    'password_hash' => $user->password_hash,
                    'email_verified_at' => $account['role'] === 'pelapor' ? $user->email_verified_at : true,
                ];
            }
        }

        if (!$matchedAccount || !Hash::check($credentials['password'], $matchedAccount['password_hash'])) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        if ($matchedAccount['role'] === 'pelapor' && !$matchedAccount['email_verified_at']) {
            $request->session()->put('pending_verification_email', $credentials['email']);
            return redirect()->route('verification.notice')->with('error', 'Email kamu belum diverifikasi. Masukkan kode yang dikirim ke Gmail.');
        }

        $request->session()->regenerate();
        $request->session()->put('auth', ['id' => $matchedAccount['id'], 'role' => $matchedAccount['role']]);
        return $this->redirectByRole($matchedAccount['role']);
    }

    public function showRegister(Request $request)
    {
        if ($request->session()->has('auth')) {
            return $this->redirectByRole($request->session()->get('auth.role'));
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'regex:/^[A-Z0-9._%+-]+@gmail\.com$/i'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
            'persetujuan' => ['accepted'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Pendaftaran Pelapor hanya menerima alamat Gmail (@gmail.com).',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'persetujuan.accepted' => 'Kamu harus menyetujui ketentuan penggunaan sistem.',
        ]);

        $email = Str::lower(trim($validated['email']));
        foreach (['super_admin', 'admin_kampus', 'satpam', 'pelapor_kehilangan'] as $table) {
            if (DB::table($table)->where('email', $email)->exists()) {
                return back()->withErrors(['email' => 'Email sudah terdaftar. Gunakan email lain.'])
                    ->withInput($request->except(['password', 'password_confirmation']));
            }
        }

        $pelaporId = DB::table('pelapor_kehilangan')->insertGetId([
            'nama' => $validated['nama'],
            'email' => $email,
            'password_hash' => Hash::make($validated['password']),
            'email_verified_at' => null,
        ], 'id_pelapor');

        $request->session()->put('pending_verification_email', $email);
        try {
            $this->sendVerificationCode($pelaporId, $email);
        } catch (\Throwable $exception) {
            report($exception);
            return redirect()->route('verification.notice')
                ->with('error', 'Akun sudah dibuat, tetapi email belum berhasil dikirim. Periksa konfigurasi SMTP lalu tekan Kirim Ulang Kode.');
        }

        return redirect()->route('verification.notice')->with('success', 'Kode verifikasi 6 digit sudah dikirim ke Gmail kamu.');
    }

    public function showVerification(Request $request)
    {
        if (!$request->session()->has('pending_verification_email')) {
            return redirect()->route('register')->with('error', 'Silakan daftar atau masuk terlebih dahulu.');
        }
        return view('auth.verify-email', ['email' => $request->session()->get('pending_verification_email')]);
    }

    public function verifyEmail(Request $request)
    {
        $validated = $request->validate(['code' => ['required', 'digits:6']]);
        $email = $request->session()->get('pending_verification_email');
        if (!$email) return redirect()->route('register')->with('error', 'Sesi verifikasi berakhir. Silakan daftar kembali.');

        $pelapor = DB::table('pelapor_kehilangan')->where('email', $email)->first();
        if (!$pelapor) return redirect()->route('register')->with('error', 'Akun Pelapor tidak ditemukan.');
        if ($pelapor->email_verified_at) return $this->finishVerification($request, $pelapor->id_pelapor);

        $record = DB::table('email_verification_codes')->where('id_pelapor', $pelapor->id_pelapor)->first();
        if (!$record || now()->greaterThan($record->expires_at)) {
            return back()->withErrors(['code' => 'Kode tidak ditemukan atau sudah kedaluwarsa. Kirim ulang kode.']);
        }
        if (!Hash::check($validated['code'], $record->code_hash)) {
            return back()->withErrors(['code' => 'Kode verifikasi salah. Periksa kembali kode dari Gmail.']);
        }

        DB::table('pelapor_kehilangan')->where('id_pelapor', $pelapor->id_pelapor)->update(['email_verified_at' => now()]);
        DB::table('email_verification_codes')->where('id_pelapor', $pelapor->id_pelapor)->delete();
        return $this->finishVerification($request, $pelapor->id_pelapor);
    }

    public function resendVerification(Request $request)
    {
        $email = $request->session()->get('pending_verification_email');
        if (!$email) return redirect()->route('register')->with('error', 'Sesi verifikasi berakhir. Silakan daftar kembali.');
        $pelapor = DB::table('pelapor_kehilangan')->where('email', $email)->first();
        if (!$pelapor) return redirect()->route('register')->with('error', 'Akun Pelapor tidak ditemukan.');
        if ($pelapor->email_verified_at) return $this->finishVerification($request, $pelapor->id_pelapor);
        try {
            $this->sendVerificationCode($pelapor->id_pelapor, $email);
        } catch (\Throwable $exception) {
            report($exception);
            return back()->with('error', 'Email gagal dikirim. Periksa konfigurasi SMTP aplikasi.');
        }
        return back()->with('success', 'Kode verifikasi baru sudah dikirim. Kode sebelumnya tidak berlaku.');
    }

    private function sendVerificationCode(int $pelaporId, string $email): void
    {
        $code = (string) random_int(100000, 999999);
        DB::table('email_verification_codes')->updateOrInsert(
            ['id_pelapor' => $pelaporId],
            ['code_hash' => Hash::make($code), 'expires_at' => now()->addMinutes(10), 'updated_at' => now(), 'created_at' => now()]
        );
        Mail::raw("Kode verifikasi Lost & Found Gunadarma kamu adalah: {$code}\n\nKode berlaku selama 10 menit. Jangan bagikan kode ini kepada siapa pun.", function ($message) use ($email) {
            $message->to($email)->subject('Kode Verifikasi Email - Lost & Found Gunadarma');
        });
    }

    private function finishVerification(Request $request, int $pelaporId)
    {
        $request->session()->forget('pending_verification_email');
        $request->session()->regenerate();
        $request->session()->put('auth', ['id' => $pelaporId, 'role' => 'pelapor']);
        return redirect()->route('dashboard.pelapor')->with('success', 'Email berhasil diverifikasi. Selamat datang!');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'super_admin' => redirect()->route('dashboard.super-admin'),
            'admin_kampus' => redirect()->route('dashboard.admin'),
            'satpam' => redirect()->route('dashboard.satpam'),
            'pelapor' => redirect()->route('dashboard.pelapor'),
            default => redirect()->route('login'),
        };
    }
}
