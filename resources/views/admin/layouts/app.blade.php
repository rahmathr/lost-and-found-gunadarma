<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Kampus - Lost &amp; Found')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0 !important;
            padding: 0 !important;
            font-family: Arial, sans-serif;
            background: #f7f5fa;
            color: #30283a;
            overscroll-behavior-y: none;
        }

        body {
            overflow-x: hidden;
        }

        /* Layout utama */
        .admin-shell {
            width: 100%;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            z-index: 1000;
            top: 0;
            bottom: 0;
            left: 0;
            width: 220px;
            height: 100vh;
            overflow-y: auto;
            background: #4b2d73;
            color: #fff;
            padding: 20px 10px;
            margin: 0;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-size: 16px;
            line-height: 1.3;
            font-weight: 700;
            padding: 0 5px;
            margin: 0 0 24px;
        }

        .admin-brand-logo {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            object-fit: contain;
            background: transparent;
        }

        .admin-brand-text {
            min-width: 0;
        }

        .admin-brand small {
            display: block;
            margin-top: 5px;
            color: #e6d9f3;
            font-size: 11px;
            font-weight: 400;
        }

        /* Navigasi */
        .admin-nav {
            display: block;
        }

        .admin-sidebar .admin-nav a {
            display: block;
            width: 100%;
            padding: 11px 10px;
            margin: 0 0 5px;
            color: #fff;
            background: transparent;
            text-decoration: none;
            border: 0;
            border-radius: 6px;
            font: 14px Arial, sans-serif;
            line-height: 1.4;
            transition: background .15s ease;
        }

        .admin-sidebar .admin-nav a:hover,
        .admin-sidebar .admin-nav a.active {
            background: #7040a5;
            color: #fff;
        }

        /* Tombol keluar */
        .admin-sidebar form {
            display: block;
            margin: 15px 0 0;
            padding: 0;
        }

        .admin-sidebar form button {
            display: block;
            width: 100%;
            padding: 11px 10px;
            margin: 0;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #fff;
            text-align: left;
            cursor: pointer;
            font: 14px Arial, sans-serif;
        }

        .admin-sidebar form button:hover {
            background: #7040a5;
        }

        /* Area utama */
        .admin-main {
            min-height: 100vh;
            margin: 0 0 0 220px;
            min-width: 0;
        }

        /* Header */
        .admin-topbar {
            min-height: 64px;
            margin: 0;
            padding: 14px 24px;
            background: #fff;
            border-bottom: 1px solid #e7e0ef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .admin-topbar h1 {
            margin: 0;
            font-size: 19px;
            line-height: 1.4;
            font-weight: 700;
            color: #392451;
        }

        .admin-user {
            font-size: 13px;
            color: #6c6177;
            text-align: right;
        }

        /* Konten */
        .admin-content {
            padding: 22px;
            min-width: 0;
            font-size: 14px;
            line-height: 1.55;
            color: #30283a;
        }

        /* Tipografi */
        .admin-content h1 {
            font-size: 25px !important;
            line-height: 1.3;
            color: #30283a;
        }

        .admin-content h2 {
            font-size: 20px !important;
            line-height: 1.35;
            color: #392451;
        }

        .admin-content h3 {
            font-size: 17px !important;
            line-height: 1.4;
            color: #392451;
        }

        .admin-content p,
        .admin-content li,
        .admin-content label {
            font-size: 14px;
            line-height: 1.55;
        }

        /* Panel dan kartu */
        .admin-content .panel,
        .admin-content .stat-card,
        .admin-content .card,
        .admin-content .form-panel {
            border: 1px solid #eee8f2;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(35,22,49,.05);
        }

        .admin-content .panel-title,
        .admin-content .panel-header {
            padding: 14px 16px;
            background: #f2edf7;
            border-bottom: 1px solid #e5e1e9;
            color: #392451;
            font-size: 16px !important;
            font-weight: 700;
        }

        .admin-content .panel-body {
            padding: 18px;
        }

        /* Statistik */
        .admin-content .stat-number {
            font-size: 28px !important;
            font-weight: 700;
            color: #4b2d73;
        }

        .admin-content .stat-label {
            font-size: 14px !important;
            color: #62596b;
        }

        /* Tabel */
        .admin-content .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .admin-content table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            background: #fff;
            font-size: 14px !important;
        }

        .admin-content th,
        .admin-content td {
            padding: 11px 12px;
            border: 1px solid #e5e1e9;
            text-align: left;
            vertical-align: middle;
            font-size: 14px !important;
            line-height: 1.45;
        }

        .admin-content th {
            background: #f2edf7;
            color: #392451;
            font-weight: 700;
        }

        .admin-content tbody tr:nth-child(even) {
            background: #faf8fc;
        }

        .admin-content tbody tr:hover {
            background: #f5f0fa;
        }

        /* Form */
        .admin-content label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
        }

        .admin-content input,
        .admin-content select,
        .admin-content textarea {
            max-width: 100%;
            width: 100%;
            min-height: 40px;
            padding: 9px 11px;
            border: 1px solid #d4cddc;
            border-radius: 6px;
            background: #fff;
            color: #30283a;
            font-family: Arial, sans-serif;
            font-size: 14px !important;
        }

        .admin-content textarea {
            min-height: 110px;
        }

        .admin-content input:focus,
        .admin-content select:focus,
        .admin-content textarea:focus {
            outline: 2px solid rgba(112,64,165,.15);
            border-color: #7040a5;
        }

        .admin-content .form-group {
            margin-bottom: 16px;
        }

        /* Tombol */
        .admin-content .btn,
        .admin-content button,
        .admin-content a.button,
        .admin-content .action-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 9px 14px;
            border-radius: 6px;
            font-size: 14px !important;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .admin-content .btn-primary,
        .admin-content .primary,
        .admin-content button[type=submit] {
            background: #4b2d73;
            border: 1px solid #4b2d73;
            color: #fff;
        }

        .admin-content .btn-primary:hover,
        .admin-content .primary:hover,
        .admin-content button[type=submit]:hover {
            background: #62408b;
        }

        .admin-content .btn-secondary,
        .admin-content .secondary {
            background: #f0edf3;
            border: 1px solid #ddd6e5;
            color: #393142;
        }

        /* Status dan pesan */
        .admin-content .status,
        .admin-content .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 13px !important;
            font-weight: 600;
            line-height: 1.4;
        }

        .admin-content .alert,
        .admin-content .success,
        .admin-content .error {
            padding: 12px 14px;
            margin-bottom: 16px;
            border-radius: 7px;
            font-size: 14px !important;
            line-height: 1.5;
        }

        .admin-content .pagination {
            margin-top: 18px;
            font-size: 14px !important;
        }

        /* Responsif */
        @media(max-width:900px) {
            .admin-content {
                padding: 16px;
            }

            .admin-content .columns,
            .admin-content .grid {
                grid-template-columns: 1fr !important;
            }
        }

        @media(max-width:650px) {
            .admin-sidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 0;
                padding: 12px;
            }

            .admin-brand {
                margin-bottom: 12px;
            }

            .admin-nav {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }

            .admin-sidebar .admin-nav a {
                width: auto;
                flex: 1 1 140px;
                margin: 0;
            }

            .admin-sidebar form {
                margin-top: 8px;
            }

            .admin-main {
                margin-left: 0;
                width: 100%;
            }

            .admin-topbar {
                min-height: 56px;
                align-items: flex-start;
                flex-direction: column;
                padding: 12px 16px;
            }

            .admin-user {
                text-align: left;
            }

            .admin-content {
                padding: 14px 12px;
            }

            .admin-content table {
                min-width: 650px;
            }

            .admin-content h1 {
                font-size: 22px !important;
            }

            .admin-content h2 {
                font-size: 18px !important;
            }
        }
    </style>

    {{-- CSS khusus halaman --}}
    @yield('pageStyles')

    {{-- Reset akhir: mencegah CSS halaman mendorong layout --}}
    <style>
        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            overscroll-behavior-y: none;
        }

        .admin-shell {
            margin: 0 !important;
            padding: 0 !important;
            position: relative;
            top: 0 !important;
        }

        .admin-sidebar {
            top: 0 !important;
        }

        .admin-main {
            margin-top: 0 !important;
        }

        .admin-topbar {
            margin-top: 0 !important;
        }
    </style>

    <style>
        .admin-main { margin-left:248px !important; }
        /* Standar sidebar lintas role: ukuran, tipografi, kategori, dan interaksi */
        .admin-sidebar {
            width:248px !important; min-width:248px !important; max-width:248px !important;
            box-sizing:border-box !important; padding:16px 12px 14px !important;
            background:#4b2d73 !important; color:#fff !important;
            font-family:Arial,sans-serif !important;
        }
        .admin-brand {
            min-height:72px !important; padding:0 4px 14px !important; margin:0 0 14px !important;
            display:flex !important; align-items:center !important; gap:11px !important;
            border-bottom:1px solid rgba(255,255,255,.16) !important;
            color:#fff !important; box-sizing:border-box !important;
        }
        .admin-brand-logo {
            width:42px !important; height:42px !important; min-width:42px !important;
            flex:0 0 42px !important; object-fit:contain !important;
        }
        .admin-sidebar .admin-brand-text, .admin-sidebar .pelapor-brand strong, .admin-sidebar .satpam-brand strong,
        .admin-sidebar .sa-brand-name {
            color:#fff !important; font-size:14px !important; line-height:1.35 !important;
            font-weight:700 !important;
        }
        .admin-sidebar .admin-brand small, .admin-sidebar .pelapor-brand small, .admin-sidebar .satpam-brand small,
        .admin-sidebar .sa-brand-role {
            display:block !important; margin-top:3px !important; color:#e6d9f3 !important;
            font-size:11px !important; line-height:1.35 !important; font-weight:400 !important;
        }
        .admin-nav {
            display:flex !important; flex-direction:column !important; align-items:stretch !important;
            gap:0 !important; width:100% !important; margin:0 !important; padding:0 !important;
            min-width:0 !important;
        }
        .admin-sidebar .nav-group {
            display:flex !important; flex-direction:column !important; gap:3px !important;
            margin:0 0 12px !important; padding:0 !important;
        }
        .admin-sidebar .nav-group-title {
            padding:7px 10px 5px !important; margin:0 !important;
            color:#d8c8e8 !important; font-size:10px !important; line-height:1.3 !important;
            font-weight:700 !important; letter-spacing:.09em !important;
            text-transform:uppercase !important;
        }
        .admin-nav a, .admin-nav button {
            display:flex !important; align-items:center !important; width:100% !important;
            min-height:40px !important; box-sizing:border-box !important;
            padding:9px 11px !important; margin:0 !important;
            border:0 !important; border-radius:7px !important;
            background:transparent !important; color:#f8f5fb !important;
            text-align:left !important; text-decoration:none !important;
            font-family:Arial,sans-serif !important; font-size:13px !important;
            font-weight:500 !important; line-height:1.35 !important;
            white-space:normal !important; cursor:pointer !important;
            transition:background .15s ease,color .15s ease !important;
        }
        .admin-nav a:hover, .admin-nav a.active, .admin-nav button:hover {
            background:#7040a5 !important; color:#fff !important;
        }
        .admin-sidebar .sidebar-logout {
            display:block !important; width:100% !important; margin:12px 0 0 !important;
            padding:12px 0 0 !important; border-top:1px solid rgba(255,255,255,.16) !important;
        }
        .admin-sidebar > form:not(.sidebar-logout) {
            display:block !important; width:100% !important; margin:12px 0 0 !important;
            padding:12px 0 0 !important; border-top:1px solid rgba(255,255,255,.16) !important;
        }
        .admin-sidebar .sidebar-logout button, .admin-sidebar > form:not(.sidebar-logout) button {
            display:flex !important; align-items:center !important; width:100% !important;
            min-height:40px !important; padding:9px 11px !important; margin:0 !important;
            border:0 !important; border-radius:7px !important; background:transparent !important;
            color:#f8f5fb !important; text-align:left !important; cursor:pointer !important;
            font:500 13px/1.35 Arial,sans-serif !important; box-shadow:none !important;
        }
        .admin-sidebar .sidebar-logout button:hover, .admin-sidebar > form:not(.sidebar-logout) button:hover {
            background:#7040a5 !important; color:#fff !important;
        }
        @media(max-width:760px) {
            .admin-sidebar {
                position:relative !important; top:auto !important; bottom:auto !important; left:auto !important;
                width:100% !important; min-width:0 !important; max-width:none !important;
                height:auto !important; min-height:0 !important; max-height:none !important;
                overflow:visible !important; padding:12px !important;
            }
            .admin-nav { display:grid !important; grid-template-columns:repeat(auto-fit,minmax(145px,1fr)) !important; gap:8px !important; }
            .admin-sidebar .nav-group { margin:0 0 8px !important; }
            .admin-sidebar .nav-group-title { padding:5px 8px !important; }
            .admin-sidebar .sidebar-logout, .admin-sidebar > form:not(.sidebar-logout) {
                margin-top:8px !important; padding-top:8px !important;
            }
            .admin-main { margin-left:0 !important; }
        }
            /* Standar tombol hapus Admin Kampus */
        .admin-content button.btn-delete,
        .admin-content .btn-delete {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 76px !important;
            min-height: 38px !important;
            padding: 8px 13px !important;
            border: 1px solid #b42318 !important;
            border-radius: 6px !important;
            background: #c62828 !important;
            color: #fff !important;
            font-family: Arial, sans-serif !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            line-height: 1.2 !important;
            text-decoration: none !important;
            cursor: pointer !important;
            box-shadow: none !important;
        }
        .admin-content button.btn-delete:hover,
        .admin-content .btn-delete:hover {
            background: #a91f1f !important;
            border-color: #941b1b !important;
            color: #fff !important;
        }
        .admin-content button.btn-delete:focus-visible,
        .admin-content .btn-delete:focus-visible {
            outline: 3px solid rgba(198,40,40,.25) !important;
            outline-offset: 2px !important;
        }

    </style>

    <link rel="stylesheet" href="{{ asset('css/lostfound-filters.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lost-found-status.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lost-found-sidebar-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lost-found-actions.css') }}?v=20261119-1">
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
    <div class="admin-shell">

        @include('admin.partials.sidebar')

        <main class="admin-main">

            <header class="admin-topbar">
                <h1>@yield('heading', 'Admin Kampus')</h1>

                <div class="admin-user">
                    Admin Kampus
                </div>
            </header>

            <section class="admin-content">
                @yield('content')
            </section>

        </main>
    </div>

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
