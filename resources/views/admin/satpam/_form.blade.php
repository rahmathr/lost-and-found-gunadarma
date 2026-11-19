<div class="satpam-form-field">
    <label for="nama">Nama Satpam</label>

    <input
        type="text"
        name="nama"
        id="nama"
        value="{{ old('nama', $satpam->nama ?? '') }}"
        maxlength="100"
        required>

    @error('nama')
        <small class="satpam-form-error">{{ $message }}</small>
    @enderror
</div>

<div class="satpam-form-field">
    <label for="email">Email</label>

    <input
        type="email"
        name="email"
        id="email"
        value="{{ old('email', $satpam->email ?? '') }}"
        maxlength="150"
        required>

    @error('email')
        <small class="satpam-form-error">{{ $message }}</small>
    @enderror
</div>

<div class="satpam-form-field">
    <label for="password">Password</label>

    <input
        type="password"
        name="password"
        id="password"
        minlength="8"
        {{ isset($satpam) ? '' : 'required' }}>

    @if (isset($satpam))
        <small class="satpam-form-help">Kosongkan jika tidak ingin mengubah password.</small>
    @else
        <small class="satpam-form-help">Password minimal 8 karakter.</small>
    @endif

    @error('password')
        <small class="satpam-form-error">{{ $message }}</small>
    @enderror
</div>

<div class="satpam-form-field">
    <label for="password_confirmation">Konfirmasi Password</label>

    <input
        type="password"
        name="password_confirmation"
        id="password_confirmation"
        minlength="8">
</div>

<div class="satpam-form-actions">
<button type="submit" class="satpam-form-button">

    {{ isset($satpam) ? 'Simpan Perubahan' : 'Tambah Satpam' }}

</button>

<a href="{{ route('admin.satpam.index') }}" class="satpam-form-cancel">
    Batal
</a>
</div>
