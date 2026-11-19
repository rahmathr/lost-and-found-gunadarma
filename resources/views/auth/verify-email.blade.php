<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Lost &amp; Found Gunadarma</title>
    <style>
        * { box-sizing: border-box; }
        html, body { min-height: 100%; }
        body {
            margin: 0; padding: 28px 16px; min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            font-family: Arial, sans-serif; color: #30283a;
            background: radial-gradient(circle at 12% 10%, rgba(112,64,165,.13), transparent 32%),
                        linear-gradient(135deg, #f8f6fb 0%, #f1edf6 100%);
        }
        .verify-shell { width: 100%; max-width: 500px; }
        .verify-brand {
            display: flex; align-items: center; justify-content: center; gap: 11px;
            margin-bottom: 18px; color: #4b2d73; font-size: 15px; font-weight: 700;
        }
        .verify-brand img { width: 42px; height: 42px; object-fit: contain; }
        .wrap {
            padding: 34px; background: #fff; border: 1px solid #e8e1ef;
            border-radius: 16px; box-shadow: 0 14px 38px rgba(49,31,69,.10);
        }
        .verify-mark {
            width: 58px; height: 58px; margin: 0 auto 18px; display: flex;
            align-items: center; justify-content: center; border-radius: 50%;
            background: #f1eafa; color: #5b3685;
        }
        .verify-mark svg { width: 29px; height: 29px; }
        h1 { margin: 0 0 10px; color: #392451; text-align: center; font-size: 23px; line-height: 1.3; }
        .intro { margin: 0; text-align: center; font-size: 14px; line-height: 1.65; color: #62596b; }
        .email {
            margin: 15px 0; padding: 12px 14px; border: 1px solid #e7dff0;
            border-radius: 9px; background: #faf8fc; color: #4b2d73;
            font-weight: 700; text-align: center; overflow-wrap: anywhere;
        }
        .instructions { margin: 0 0 22px; text-align: center; color: #716879; font-size: 13px; line-height: 1.6; }
        .notice { padding: 11px 13px; margin: 14px 0; border-radius: 8px; font-size: 13px; line-height: 1.5; }
        .success { background: #effaf0; color: #256b35; border: 1px solid #a8d5ae; }
        .error { background: #fff2f2; color: #a12626; border: 1px solid #efb5b5; }
        label { display: block; margin: 0 0 8px; color: #393142; font-size: 13px; font-weight: 700; }
        input {
            display: block; width: 100%; height: 54px; padding: 10px 14px;
            border: 1px solid #d4cddc; border-radius: 9px; background: #fff;
            color: #30283a; font-size: 23px; font-weight: 700;
            letter-spacing: 10px; text-align: center;
        }
        input:focus { outline: 3px solid rgba(112,64,165,.13); border-color: #7040a5; }
        button {
            width: 100%; margin-top: 14px; min-height: 46px; padding: 11px 16px;
            border: 0; border-radius: 8px; background: #4b2d73; color: #fff;
            font-size: 14px; font-weight: 700; cursor: pointer;
        }
        button:hover { background: #62408b; }
        .resend { margin-top: 10px; background: #f0eaf6; color: #4b2d73; border: 1px solid #e2d7ee; }
        .resend:hover { background: #e7def0; }
        .back { margin-top: 21px; text-align: center; font-size: 13px; }
        .back a { color: #7040a5; font-weight: 700; text-decoration: none; }
        .back a:hover { text-decoration: underline; }
        @media (max-width: 520px) { .wrap { padding: 26px 20px; } h1 { font-size: 21px; } }
    </style>
</head>
<body>
<div class="verify-shell">
<div class="verify-brand">
    <img src="{{ asset('images/gunadarma-logo.png') }}" alt="Logo Universitas Gunadarma">
    <span>Lost &amp; Found Gunadarma</span>
</div>
<div class="wrap">
    <div class="verify-mark" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
            <path d="m3 7 9 6 9-6"></path>
        </svg>
    </div>
    <h1>Verifikasi Alamat Gmail</h1>
    <p class="intro">Satu langkah lagi untuk mengaktifkan akun Pelapor.</p>
    <div class="email">{{ $email }}</div>
    <p class="instructions">Masukkan kode verifikasi 6 digit yang kami kirim ke email tersebut. Kode berlaku selama 10 menit.</p>
    @if(session('success'))<div class="notice success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="notice error">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="notice error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    <form method="POST" action="{{ route('verification.verify') }}">
        @csrf
        <label for="code">Kode verifikasi</label>
        <input id="code" name="code" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" minlength="6" autocomplete="one-time-code" required autofocus>
        <button type="submit">Verifikasi Email</button>
    </form>
    <form method="POST" action="{{ route('verification.resend') }}">@csrf<button class="resend" type="submit">Kirim Ulang Kode</button></form>
    <div class="back"><a href="{{ route('login') }}">Kembali ke halaman masuk</a></div>
</div>
</div>
</body>
</html>
