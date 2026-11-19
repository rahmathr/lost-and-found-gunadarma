<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Area Satpam - Lost &amp; Found Gundar')</title>
    <style>
        *{box-sizing:border-box}
        html,body{margin:0;min-height:100%;font-family:Arial,sans-serif;color:#30283a;background:#f7f5fa}
        .satpam-shell{display:flex;min-height:100vh}
        .satpam-sidebar{width:240px;flex:0 0 240px;background:#4b2d73;color:#fff;display:flex;flex-direction:column}
        .satpam-brand{display:flex;align-items:center;gap:10px;padding:16px 14px;min-height:82px;border-bottom:1px solid rgba(255,255,255,.14)}
        .satpam-brand img{width:42px;height:42px;object-fit:contain;background:transparent;border-radius:0;padding:0}
        .satpam-brand strong{display:block;font-size:13px;line-height:1.35}
        .satpam-brand small{display:block;margin-top:3px;color:#e6d9f3;font-size:10px}
        .satpam-nav{padding:12px 10px;display:flex;flex-direction:column;gap:5px}
        .satpam-nav a,.satpam-nav button{display:block;width:100%;padding:11px 12px;border:0;border-radius:6px;background:transparent;color:#fff;text-align:left;text-decoration:none;font-size:13px;cursor:pointer}
        .satpam-nav a:hover,.satpam-nav a.active,.satpam-nav button:hover{background:#7040a5}
        .satpam-nav form{margin-top:10px}
        .satpam-main{flex:1;min-width:0}
        .satpam-topbar{min-height:64px;padding:12px 24px;background:#fff;border-bottom:1px solid #e7e0ef;display:flex;justify-content:space-between;align-items:center;gap:14px;min-width:0;flex-wrap:wrap}
        .satpam-topbar h1{font-size:18px;margin:0;color:#392451}
        .satpam-user{font-size:12px;color:#6c6177;text-align:right;min-width:0;max-width:100%;overflow-wrap:anywhere;white-space:normal}
        .satpam-content{padding:22px;min-width:0;width:100%;max-width:100%;overflow-x:hidden}
        .satpam-content table{max-width:100%}
        .satpam-content .table-responsive,.satpam-content .table-body{overflow-x:auto}
        .satpam-content input,.satpam-content select,.satpam-content textarea{max-width:100%}
        .satpam-content .container{margin:0 auto!important}
        @media(max-width:760px){.satpam-shell{display:block}.satpam-sidebar{width:100%;min-height:0}.satpam-brand{min-height:66px}.satpam-nav{flex-direction:row;flex-wrap:wrap;padding:8px}.satpam-nav a,.satpam-nav button{width:auto;flex:1 1 auto}.satpam-nav form{margin:0;flex:1 1 auto}.satpam-topbar{align-items:flex-start;flex-direction:column;padding:14px 16px}.satpam-user{text-align:left}.satpam-content{padding:14px}.satpam-content .stats{grid-template-columns:repeat(2,minmax(0,1fr))!important}.satpam-content .columns{grid-template-columns:1fr!important}}
    </style>
    @stack('styles')
    <style>

        /* Reset posisi halaman agar layout Satpam menempel ke sisi atas viewport */
        html,body{margin:0!important;padding:0!important;min-height:100%!important}
        body{position:static!important;top:0!important;transform:none!important}
        .satpam-shell{margin:0!important;padding:0!important;position:relative!important;top:0!important;transform:none!important}
        .satpam-sidebar,.satpam-main{margin-top:0!important}
        /* Audit konsistensi seluruh menu Satpam */
        .satpam-content{font-size:14px;line-height:1.55;color:#30283a}
        .satpam-content h1{font-size:25px!important;line-height:1.3;color:#30283a;margin:0 0 10px}
        .satpam-content h2{font-size:19px!important;line-height:1.35;color:#392451}
        .satpam-content h3{font-size:16px!important;line-height:1.4;color:#392451}
        .satpam-content p,.satpam-content li{font-size:14px;line-height:1.55}
        .satpam-content label{font-size:14px!important;font-weight:600;line-height:1.4}
        .satpam-content input,.satpam-content select,.satpam-content textarea{font-size:14px!important;min-height:40px;padding:9px 11px;border:1px solid #d4cddc;border-radius:6px}
        .satpam-content textarea{min-height:110px}
        .satpam-content table{width:100%;border-collapse:collapse;background:#fff;font-size:14px!important}
        .satpam-content th,.satpam-content td{font-size:14px!important;line-height:1.45;padding:11px 12px;border:1px solid #e5e1e9!important;vertical-align:middle}
        .satpam-content th{background:#f2edf7!important;color:#392451;font-weight:700}
        .satpam-content tbody tr:nth-child(even){background:#faf8fc}
        .satpam-content .panel,.satpam-content .satpam-form-page,.satpam-content .satpam-detail-page,
        .satpam-content .welcome,.satpam-content .stat-card{border:1px solid #eee8f2!important;border-radius:10px!important;box-shadow:0 2px 8px rgba(35,22,49,.05)}
        .satpam-content .panel{background:#fff}
        .satpam-content .panel-header{padding:13px 16px!important;background:#f2edf7!important;border-bottom:1px solid #e5e1e9!important;font-size:15px!important;color:#392451}
        .satpam-content .form-body{padding:18px!important}
        .satpam-content .form-group{margin-bottom:16px}
        .satpam-content .status-info,.satpam-content .note{font-size:13px!important;line-height:1.55}
        .satpam-content .badge,.satpam-content .status{font-size:13px!important;padding:5px 10px}
        .satpam-content .field-error{font-size:13px!important}
        .satpam-content .alert{font-size:14px!important;line-height:1.5;border-radius:7px}
        .satpam-content button,.satpam-content .btn,.satpam-content a.button,
        .satpam-content .detail,.satpam-content .satpam-form-page a,
        .satpam-content .satpam-form-page button{display:inline-flex;align-items:center;justify-content:center;min-height:40px;padding:9px 15px;border-radius:6px;font-size:14px!important;font-weight:600;text-decoration:none}
        .satpam-content .primary,.satpam-content button[type=submit],
        .satpam-content .satpam-form-page button{background:#4b2d73!important;border-color:#4b2d73!important;color:#fff!important}
        .satpam-content .primary:hover,.satpam-content button[type=submit]:hover{background:#62408b!important}
        .satpam-content .satpam-form-page,.satpam-content .satpam-detail-page{max-width:900px!important;padding:24px!important;background:#fff!important}
        .satpam-content .satpam-form-page h1,.satpam-content .satpam-detail-page h1{margin:0 0 16px}
        .satpam-content .satpam-form-page label{display:block;margin:0 0 7px}
        .satpam-content .satpam-form-page input,.satpam-content .satpam-form-page select,
        .satpam-content .satpam-form-page textarea{display:block;width:100%;margin-top:5px}
        .satpam-content .satpam-detail-page .detail{display:block;padding:12px 0;border-bottom:1px solid #eee}
        .satpam-content .satpam-detail-page .label{display:block;font-size:14px;margin-bottom:5px}
        .satpam-content .filters{padding:16px;background:#fff;border:1px solid #eee8f2;border-radius:9px}
        .satpam-content .filters button,.satpam-content .filters .button{min-height:40px}
        .satpam-content .pagination{font-size:14px!important}
        .satpam-content .welcome{padding:20px!important;background:#fff}
        .satpam-content .stat-card{padding:18px!important;background:#fff}
        .satpam-content .stat-label{font-size:14px!important}
        .satpam-content .stat-number{font-size:27px!important}
        @media(max-width:760px){
          .satpam-content{padding:14px}
          .satpam-content h1{font-size:22px!important}
          .satpam-content .satpam-form-page,.satpam-content .satpam-detail-page{padding:17px!important}
          .satpam-content .columns{grid-template-columns:1fr!important}
          .satpam-content .two-columns{grid-template-columns:1fr!important}
          .satpam-content .table-body,.satpam-content .table-responsive{overflow-x:auto}
          .satpam-content table{min-width:650px}
        }


    </style>

    <style>
        /* Standar sidebar lintas role: ukuran, tipografi, kategori, dan interaksi */
        .satpam-sidebar {
            width:248px !important; min-width:248px !important; max-width:248px !important;
            box-sizing:border-box !important; padding:16px 12px 14px !important;
            background:#4b2d73 !important; color:#fff !important;
            font-family:Arial,sans-serif !important;
        }
        .satpam-brand {
            min-height:72px !important; padding:0 4px 14px !important; margin:0 0 14px !important;
            display:flex !important; align-items:center !important; gap:11px !important;
            border-bottom:1px solid rgba(255,255,255,.16) !important;
            color:#fff !important; box-sizing:border-box !important;
        }
        .satpam-brand img {
            width:42px !important; height:42px !important; min-width:42px !important;
            flex:0 0 42px !important; object-fit:contain !important;
        }
        .satpam-sidebar .admin-brand-text, .satpam-sidebar .pelapor-brand strong, .satpam-sidebar .satpam-brand strong,
        .satpam-sidebar .sa-brand-name {
            color:#fff !important; font-size:14px !important; line-height:1.35 !important;
            font-weight:700 !important;
        }
        .satpam-sidebar .admin-brand small, .satpam-sidebar .pelapor-brand small, .satpam-sidebar .satpam-brand small,
        .satpam-sidebar .sa-brand-role {
            display:block !important; margin-top:3px !important; color:#e6d9f3 !important;
            font-size:11px !important; line-height:1.35 !important; font-weight:400 !important;
        }
        .satpam-nav {
            display:flex !important; flex-direction:column !important; align-items:stretch !important;
            gap:0 !important; width:100% !important; margin:0 !important; padding:0 !important;
            min-width:0 !important;
        }
        .satpam-sidebar .nav-group {
            display:flex !important; flex-direction:column !important; gap:3px !important;
            margin:0 0 12px !important; padding:0 !important;
        }
        .satpam-sidebar .nav-group-title {
            padding:7px 10px 5px !important; margin:0 !important;
            color:#d8c8e8 !important; font-size:10px !important; line-height:1.3 !important;
            font-weight:700 !important; letter-spacing:.09em !important;
            text-transform:uppercase !important;
        }
        .satpam-nav a, .satpam-nav button {
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
        .satpam-nav a:hover, .satpam-nav a.active, .satpam-nav button:hover {
            background:#7040a5 !important; color:#fff !important;
        }
        .satpam-sidebar .sidebar-logout {
            display:block !important; width:100% !important; margin:12px 0 0 !important;
            padding:12px 0 0 !important; border-top:1px solid rgba(255,255,255,.16) !important;
        }
        .satpam-sidebar > form:not(.sidebar-logout) {
            display:block !important; width:100% !important; margin:12px 0 0 !important;
            padding:12px 0 0 !important; border-top:1px solid rgba(255,255,255,.16) !important;
        }
        .satpam-sidebar .sidebar-logout button, .satpam-sidebar > form:not(.sidebar-logout) button {
            display:flex !important; align-items:center !important; width:100% !important;
            min-height:40px !important; padding:9px 11px !important; margin:0 !important;
            border:0 !important; border-radius:7px !important; background:transparent !important;
            color:#f8f5fb !important; text-align:left !important; cursor:pointer !important;
            font:500 13px/1.35 Arial,sans-serif !important; box-shadow:none !important;
        }
        .satpam-sidebar .sidebar-logout button:hover, .satpam-sidebar > form:not(.sidebar-logout) button:hover {
            background:#7040a5 !important; color:#fff !important;
        }
        @media(max-width:760px) {
            .satpam-sidebar {
                position:relative !important; top:auto !important; bottom:auto !important; left:auto !important;
                width:100% !important; min-width:0 !important; max-width:none !important;
                height:auto !important; min-height:0 !important; max-height:none !important;
                overflow:visible !important; padding:12px !important;
            }
            .satpam-nav { display:grid !important; grid-template-columns:repeat(auto-fit,minmax(145px,1fr)) !important; gap:8px !important; }
            .satpam-sidebar .nav-group { margin:0 0 8px !important; }
            .satpam-sidebar .nav-group-title { padding:5px 8px !important; }
            .satpam-sidebar .sidebar-logout, .satpam-sidebar > form:not(.sidebar-logout) {
                margin-top:8px !important; padding-top:8px !important;
            }
            .satpam-main { margin-left:0 !important; }
        }
            /* Standar tombol hapus Satpam */
        .satpam-content button.btn-delete,
        .satpam-content .btn-delete {
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
        .satpam-content button.btn-delete:hover,
        .satpam-content .btn-delete:hover {
            background: #a91f1f !important;
            border-color: #941b1b !important;
            color: #fff !important;
        }
        .satpam-content button.btn-delete:focus-visible,
        .satpam-content .btn-delete:focus-visible {
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
<div class="satpam-shell">
    <aside class="satpam-sidebar">
        <div class="satpam-brand">
            <img src="{{ asset('images/gunadarma-logo.png') }}" alt="Logo Universitas Gunadarma">
            <div><strong>Lost &amp; Found Gundar</strong><small>Satpam / Petugas Keamanan</small></div>
        </div>
        <nav class="satpam-nav" aria-label="Navigasi Satpam">
            <div class="nav-group">
                <div class="nav-group-title">Ringkasan</div>
                <a href="{{ route('dashboard.satpam') }}" class="{{ request()->routeIs('dashboard.satpam') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'dashboard']) Dashboard</a>
            </div>
            <div class="nav-group">
                <div class="nav-group-title">Barang Temuan</div>
                <a href="{{ route('satpam.barang-temuan.index') }}" class="{{ request()->routeIs('satpam.barang-temuan.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'package-check']) Penerimaan Barang</a>
            </div>
            <div class="nav-group">
                <div class="nav-group-title">Arsip</div>
                <a href="{{ route('satpam.riwayat-penerimaan.index') }}" class="{{ request()->routeIs('satpam.riwayat-penerimaan.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'history']) Riwayat Penerimaan</a>
            </div>
            <form class="sidebar-logout" action="{{ route('logout') }}" method="POST">@csrf<button type="submit">@include('shared.sidebar-icon', ['name' => 'log-out']) Keluar</button></form>
        </nav>
    </aside>
    <main class="satpam-main">
        <header class="satpam-topbar"><h1>@yield('heading')</h1><div class="satpam-user">{{ $satpam->nama ?? auth()->user()->name ?? 'Satpam' }} · {{ $satpam->kampus->nama_kampus ?? 'Kampus' }}</div></header>
        <div class="satpam-content">@yield('content')</div>
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
