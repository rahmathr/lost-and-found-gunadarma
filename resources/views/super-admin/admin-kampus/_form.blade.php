<div class="sa-form-grid">
    <div class="sa-field">
        <label for="id_kampus">Kampus</label>
        <select name="id_kampus" id="id_kampus" required>
            <option value="">-- Pilih Kampus --</option>
            @foreach ($kampus as $item)
                <option value="{{ $item->id_kampus }}" @selected(old('id_kampus', $adminKampus->id_kampus ?? '') == $item->id_kampus)>
                    {{ $item->nama_kampus }}
                </option>
            @endforeach
        </select>
        @error('id_kampus') <p class="sa-error">{{ $message }}</p> @enderror
    </div>

    <div class="sa-field">
        <label for="nama">Nama Admin</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama', $adminKampus->nama ?? '') }}" maxlength="100" required>
        @error('nama') <p class="sa-error">{{ $message }}</p> @enderror
    </div>

    <div class="sa-field">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $adminKampus->email ?? '') }}" maxlength="150" required>
        @error('email') <p class="sa-error">{{ $message }}</p> @enderror
    </div>

    <div class="sa-field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" minlength="8" {{ isset($adminKampus) ? '' : 'required' }}>
        @if (isset($adminKampus))
            <small>Kosongkan jika tidak ingin mengubah password.</small>
        @else
            <small>Password minimal 8 karakter.</small>
        @endif
        @error('password') <p class="sa-error">{{ $message }}</p> @enderror
    </div>

    <div class="sa-field">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" minlength="8">
    </div>
</div>

<div class="sa-form-actions">
    <button type="submit" class="sa-btn sa-btn-primary">
        {{ isset($adminKampus) ? 'Simpan Perubahan' : 'Tambah Admin Kampus' }}
    </button>
    <a href="{{ route('super-admin.admin-kampus.index') }}" class="sa-btn sa-btn-secondary">Batal</a>
</div>
