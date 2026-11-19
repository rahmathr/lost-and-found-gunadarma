<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Lost & Found Gundar</title>

    <style>
        *{box-sizing:border-box}
        html,body{width:100%;min-height:100%;margin:0!important;padding:0!important}
        body{display:block;font-family:Arial,sans-serif;color:#30283a;background:#f7f5fa;overflow-x:hidden}
        header.navbar{display:flex!important;position:fixed!important;top:0!important;left:0!important;right:0!important;width:100%!important;margin:0!important;padding-top:10px;padding-bottom:10px;border:0;border-radius:0;z-index:1000;}
        .navbar{min-height:70px;display:flex;align-items:center;gap:12px;padding:10px 28px;background:#4b2d73;color:#fff;box-shadow:0 2px 8px rgba(35,22,49,.12)}
        .logo{width:44px;height:44px;flex:0 0 44px;display:flex;align-items:center;justify-content:center}
        .logo img{width:100%;height:100%;object-fit:contain;display:block;background:transparent}
        .brand{font-size:16px;font-weight:700;white-space:nowrap;color:#fff}
        .nav-links{display:flex;align-items:center;gap:12px;margin-left:auto}
        .nav-links a{display:inline-flex;align-items:center;justify-content:center;min-height:38px;padding:9px 13px;color:#f4edf9;text-decoration:none;font-size:14px;border-radius:6px}
        .nav-links a:hover,.nav-links a.active{background:#7040a5;color:#fff}
        .nav-links .register-button{background:#fff;color:#4b2d73;font-weight:700}
        .nav-links .register-button:hover{background:#eee7f5;color:#392451}
        main{width:100%;padding:104px 16px 48px}
        .form-container{width:min(100%,480px);margin:0 auto;padding:28px 30px;background:#fff;border:1px solid #eee8f2;border-radius:12px;box-shadow:0 6px 22px rgba(35,22,49,.08)}
        .form-title{margin:0;text-align:center;color:#392451;font-size:23px;line-height:1.3}
        .subtitle{margin:9px 0 24px;text-align:center;color:#716879;font-size:14px;line-height:1.5}
        .form-group{margin-bottom:18px}
        label{display:block;margin:0 0 7px;color:#393142;font-size:14px;font-weight:600}
        input[type=text],input[type=email],input[type=password]{display:block;width:100%;height:44px;padding:10px 12px;border:1px solid #d4cddc;border-radius:6px;background:#fff;color:#30283a;font-family:Arial,sans-serif;font-size:14px}
        input:focus{outline:2px solid rgba(112,64,165,.16);border-color:#7040a5}
        .agreement{display:flex;align-items:flex-start;gap:9px;margin:17px 0 20px;color:#4b4452;font-size:14px;line-height:1.5}
        .agreement input{width:17px;height:17px;flex:0 0 17px;margin:1px 0 0;accent-color:#7040a5}
        .agreement label{margin:0;font-size:14px;font-weight:400}
        .submit-button{display:flex;align-items:center;justify-content:center;width:100%;min-height:44px;padding:11px 16px;border:0;border-radius:6px;background:#4b2d73;color:#fff;font-size:14px;font-weight:700;cursor:pointer}
        .submit-button:hover{background:#62408b}
        .form-footer{margin-top:20px;text-align:center;color:#62596b;font-size:14px}
        .form-footer a{color:#7040a5;font-weight:700;text-decoration:none}
        .form-footer a:hover{text-decoration:underline}
        .alert-success,.alert-error{padding:12px 14px;margin-bottom:18px;border-radius:7px;font-size:14px;line-height:1.5}
        .alert-success{border:1px solid #a8d5ae;background:#effaf0;color:#256b35}
        .alert-error{border:1px solid #efb5b5;background:#fff2f2;color:#a12626}
        .input-error{margin-top:5px;color:#b42318;font-size:13px}
        @media(max-width:600px){.navbar{padding:10px 14px;flex-wrap:wrap}.brand{font-size:14px}.nav-links{width:100%;margin:4px 0 0;gap:6px}.nav-links a{flex:1;padding:8px 7px;font-size:13px}main{padding:94px 12px 32px}.form-container{padding:23px 18px}.form-title{font-size:21px}}

/* FIX: tombol Daftar harus selalu terlihat di navbar autentikasi */
.navbar > .nav-links > a.register-button,
.navbar > .nav-links > a.register-button.active,
.navbar > .nav-links > a.register-button:hover {
    background: #7040a5 !important;
    color: #ffffff !important;
    border-radius: 6px !important;
    font-weight: 700 !important;
}

</style>
<style>

/* Password toggle control: scoped so it cannot inherit global button sizing */
button.lf-password-toggle,
button.lf-password-toggle:hover,
button.lf-password-toggle:focus,
button.lf-password-toggle:focus-visible {
 position:absolute!important;right:6px!important;z-index:20!important;
 display:inline-flex!important;align-items:center!important;justify-content:center!important;
 width:34px!important;min-width:34px!important;max-width:34px!important;
 height:32px!important;min-height:32px!important;max-height:32px!important;
 margin:0!important;padding:0!important;border:0!important;border-radius:5px!important;
 background:transparent!important;box-shadow:none!important;color:#62408b!important;
 text-align:center!important;line-height:1!important;cursor:pointer!important;
}
button.lf-password-toggle:hover{background:#f1ebf7!important}
button.lf-password-toggle:focus-visible{outline:2px solid #7040a5!important;outline-offset:1px!important}
button.lf-password-toggle svg{display:block!important;width:19px!important;height:19px!important;min-width:19px!important;min-height:19px!important;stroke:currentColor!important;pointer-events:none!important}

</style>
</head>

<body>

    <header class="navbar">

        <div class="logo"><img src="{{ asset('images/gunadarma-logo.png') }}" alt="Logo Universitas Gunadarma"></div>

        <div class="brand">
            Lost &amp; Found Gundar
        </div>

        <nav class="nav-links">
            <a href="{{ url('/') }}">Beranda</a>
            <a href="{{ route('public.barang.index') }}">Cari Barang</a>
            <a href="{{ route('login') }}" class="active">Masuk</a>
            <a href="{{ route('register') }}" class="register-button">Daftar</a>
        </nav>

    </header>

    <main>

        <div class="form-container">

            <h1 class="form-title">Masuk ke Sistem</h1>

            <p class="subtitle">Digunakan oleh semua peran</p>

            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="nama@email.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <button type="submit" class="submit-button">
                    Masuk
                </button>

            </form>

            <div class="form-footer">
                Belum punya akun?
                <a href="{{ route('register') }}">
                    Daftar sebagai Pelapor
                </a>
            </div>

        </div>

    </main>


<script id="lf-password-toggle-script">
(function(){
 function icon(show){return show
 ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"></path><circle cx="12" cy="12" r="3"></circle><path d="m3 3 18 18"></path></svg>'
 : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7S2 12 2 12Z"></path><circle cx="12" cy="12" r="3"></circle></svg>';}
 function init(){
  document.querySelectorAll('input[type="password"]:not([data-lf-toggle-ready])').forEach(function(input){
   var parent=input.parentElement;if(!parent)return;
   input.dataset.lfToggleReady='1';
   if(getComputedStyle(parent).position==='static')parent.style.position='relative';
   input.style.setProperty('padding-right','48px','important');
   var b=document.createElement('button');b.type='button';b.className='lf-password-toggle';
   b.setAttribute('aria-label','Tampilkan kata sandi');b.setAttribute('aria-pressed','false');b.innerHTML=icon(false);
   b.addEventListener('click',function(){var show=input.type==='password';input.type=show?'text':'password';b.innerHTML=icon(show);b.setAttribute('aria-label',show?'Sembunyikan kata sandi':'Tampilkan kata sandi');b.setAttribute('aria-pressed',show?'true':'false');input.focus();});
   parent.appendChild(b);
   function place(){b.style.setProperty('top',(input.offsetTop+Math.max(0,(input.offsetHeight-32)/2))+'px','important');}
   place();window.addEventListener('resize',place);
  });
 }
 if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();
</script>

</body>
</html>
