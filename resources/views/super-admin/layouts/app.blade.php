<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Super Admin - Lost &amp; Found')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            min-height: 100%;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .sa-shell {
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sa-sidebar {
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
            padding: 25px 10px 20px;
        }

        /* LOGO DAN IDENTITAS */
        .sa-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 5px;
            margin: 0 0 30px;
            color: #fff;
        }

        .sa-logo {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            border: 1px solid #aaa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 10px;
            font-weight: 400;
            border: 0;
        }

        .sa-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .sa-brand-name {
            color: #fff;
            font-size: 13px;
            line-height: 1.3;
            font-weight: 700;
        }

        .sa-brand-role {
            margin-top: 4px;
            color: #ccc;
            font-size: 10px;
            font-weight: 400;
        }

        /* NAVIGASI */
        .sa-nav {
            display: block;
            width: 100%;
            margin-top: 15px;
            padding: 0;
        }

        .sa-nav a {
            display: block;
            width: 100%;
            padding: 12px 10px;
            margin: 0 0 5px;
            color: #fff;
            background: transparent;
            text-decoration: none;
            border: 0;
            border-radius: 0;
            font: 13px Arial, sans-serif;
            line-height: 1.25;
        }

        .sa-nav a:hover,
        .sa-nav a.active {
            background: #7040a5;
            color: #fff;
        }

        /* TOMBOL KELUAR */
        .sa-sidebar form {
            display: block;
            margin: 15px 0 0;
            padding: 0;
        }

        .sa-sidebar form button {
            display: block;
            width: 100%;
            padding: 12px 10px;
            margin: 0;
            border: 0;
            border-radius: 0;
            background: transparent;
            color: #fff;
            text-align: left;
            cursor: pointer;
            font: 13px Arial, sans-serif;
            box-shadow: none;
        }

        .sa-sidebar form button:hover {
            background: #5c328b;
        }

        /* KONTEN UTAMA */
        .sa-main {
            min-height: 100vh;
            margin-left: 220px;
            min-width: 0;
        }

        /* HEADER */
        .sa-topbar {
            min-height: 56px;
            padding: 17px 24px;
            background: #eee7f5;
            border-bottom: 1px solid #c9b2e6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .sa-topbar h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }

        .sa-user {
            font-size: 12px;
            color: #555;
            text-align: right;
        }

        /* AREA KONTEN */
        .sa-content {
            padding: 20px;
            min-width: 0;
        }

        .sa-card {
            background: #fff;
            border: 1px solid #ccc;
            padding: 18px;
            margin-bottom: 18px;
        }

        .sa-card h2,
        .sa-card h3 {
            margin: 0 0 15px;
        }

        .sa-description {
            margin: 0 0 18px;
            color: #666;
            line-height: 1.5;
        }

        .sa-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 9px;
            margin-bottom: 15px;
        }

        /* TOMBOL */
        .sa-btn {
            display: inline-block;
            padding: 10px 14px;
            border: 1px solid #777;
            border-radius: 4px;
            background: #fff;
            color: #333;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            font: 13px Arial, sans-serif;
        }

        .sa-btn-primary {
            background: #7040a5;
            border-color: #7040a5;
            color: #fff;
        }

        .sa-btn-primary:hover {
            background: #5c328b;
        }

        .sa-btn-danger {
            background: #b42318;
            border-color: #b42318;
            color: #fff;
        }

        .sa-btn-secondary {
            background: #eee;
        }

        /* ALERT */
        .sa-alert {
            padding: 11px 13px;
            margin: 0 0 15px;
            border: 1px solid #b7d7b9;
            background: #eef8ef;
            color: #245b2a;
        }

        .sa-alert-error {
            border-color: #e5b8b8;
            background: #fff1f1;
            color: #8b2525;
        }

        /* TABEL */
        .sa-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .sa-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            background: #fff;
        }

        .sa-table th,
        .sa-table td {
            padding: 11px 10px;
            border: 1px solid #ccc;
            text-align: left;
            vertical-align: top;
        }

        .sa-table th {
            background: #eee7f5;
            font-weight: 700;
            white-space: nowrap;
        }

        .sa-table tbody tr:nth-child(even) {
            background: #f8f8f8;
        }

        /* FORM */
        .sa-form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            max-width: 760px;
        }

        .sa-field label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 700;
        }

        .sa-field input,
        .sa-field select,
        .sa-field textarea {
            width: 100%;
            max-width: 100%;
            padding: 10px 11px;
            border: 1px solid #aaa;
            border-radius: 4px;
            background: #fff;
            color: #333;
            font: 13px Arial, sans-serif;
        }

        .sa-field textarea {
            min-height: 105px;
            resize: vertical;
        }

        .sa-error {
            margin: 5px 0 0;
            color: #b42318;
            font-size: 12px;
        }

        .sa-pagination {
            margin-top: 18px;
        }

        /* FILTER */
        .sa-filter {
            display: flex;
            flex-wrap: wrap;
            align-items: end;
            gap: 12px;
            padding: 15px;
            margin-bottom: 16px;
            background: #f8f8f8;
            border: 1px solid #ccc;
        }

        .sa-filter .sa-field {
            min-width: 170px;
        }

        /* RESPONSIVE */
        @media (max-width: 700px) {
            .sa-sidebar {
                width: 190px;
                padding: 18px 8px;
            }

            .sa-main {
                margin-left: 190px;
            }

            .sa-brand {
                font-size: 15px;
            }

            .sa-nav a {
                font-size: 12px;
                padding: 10px 7px;
            }

            .sa-content {
                padding: 10px;
            }

            .sa-topbar {
                padding: 13px;
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    @stack('styles')


<style>
/* Standar visual Super Admin: tipografi, panel, tabel, tombol, dan formulir */
html,body{background:#f7f5fa;color:#30283a}
.sa-sidebar{background:#4b2d73}
.sa-logo{background:transparent;border:0}
.sa-logo img{background:transparent;object-fit:contain}
.sa-brand-name{font-size:15px}
.sa-brand-role{font-size:12px}
.sa-nav a,.sa-sidebar form button{font-size:14px;line-height:1.4;border-radius:6px}
.sa-nav a{padding:11px 12px;margin-bottom:5px}
.sa-nav a:hover,.sa-nav a.active,.sa-sidebar form button:hover{background:#7040a5}
.sa-main{background:#f7f5fa}
.sa-topbar{min-height:64px;padding:16px 26px;background:#fff;border-bottom:1px solid #eee8f2}
.sa-topbar h1{font-size:21px;line-height:1.35;color:#30283a}
.sa-user{font-size:13px;color:#62596b}
.sa-content{padding:24px 26px 34px}
.sa-card{background:#fff;border:1px solid #eee8f2;border-radius:10px;padding:22px 24px;margin-bottom:20px;box-shadow:0 2px 8px rgba(35,22,49,.05)}
.sa-card h2,.sa-card h3{font-size:18px;line-height:1.4;color:#30283a}
.sa-description{font-size:14px;line-height:1.6;color:#62596b}
.sa-actions{gap:9px}
.sa-btn{display:inline-flex;align-items:center;justify-content:center;min-height:38px;padding:9px 14px;border:1px solid #ddd6e5;border-radius:6px;background:#f4f1f7;color:#393142;text-decoration:none;text-align:center;font:600 14px Arial,sans-serif}
.sa-btn-primary{background:#4b2d73;border-color:#4b2d73;color:#fff}
.sa-btn-primary:hover{background:#62408b;border-color:#62408b}
.sa-btn-danger{background:#b42318;border-color:#b42318;color:#fff}
.sa-btn-secondary{background:#eef0f4;border-color:#e1dce8;color:#393142}
.sa-alert{padding:13px 15px;border:1px solid #b7d7b9;border-radius:7px;font-size:14px;line-height:1.5}
.sa-alert-error{border-color:#e5b8b8;background:#fff1f1;color:#8b2525}
.sa-table{font-size:14px!important;border-collapse:collapse}
.sa-table th,.sa-table td{padding:12px 13px;border:1px solid #e5e1e9;text-align:left;vertical-align:middle;font-size:14px;line-height:1.45}
.sa-table th{background:#f2edf7;color:#30283a}
.sa-table tbody tr:nth-child(even){background:#faf8fc}
.sa-table tbody tr:hover{background:#f6f1fa}
.sa-form-grid{gap:17px;max-width:820px}
.sa-field label{display:block;margin-bottom:7px;font-size:14px;font-weight:600;color:#393142}
.sa-field input,.sa-field select,.sa-field textarea{min-height:42px;padding:10px 12px;border:1px solid #d4cddc;border-radius:6px;background:#fff;color:#30283a;font:14px Arial,sans-serif}
.sa-field textarea{min-height:115px}
.sa-error{font-size:13px;line-height:1.45}
.sa-filter{padding:17px;background:#faf8fc;border:1px solid #eee8f2;border-radius:8px}
.sa-filter .sa-field{min-width:190px}
.sa-filter .sa-field input,.sa-filter .sa-field select{min-width:190px}
.sa-pagination{font-size:14px}
.sa-pagination a,.sa-pagination span{font-size:13px}
.sa-admin-table{font-size:14px!important}
.sa-admin-table th,.sa-admin-table td{padding:12px 10px;font-size:14px;line-height:1.45;border-color:#e5e1e9}
.sa-admin-table th{background:#f2edf7;color:#30283a}
.sa-admin-form-panel{min-height:0;padding:22px;border:1px solid #eee8f2;border-radius:9px;background:#fff;box-shadow:0 2px 8px rgba(35,22,49,.05)}
.sa-admin-form-panel h2{font-size:18px}
.sa-admin-field label{font-size:14px}
.sa-admin-field input,.sa-admin-field select{height:42px;padding:10px 12px;font:14px Arial,sans-serif}
.sa-admin-field small,.sa-admin-field .sa-error{font-size:13px;line-height:1.45}
.sa-admin-validation{padding:13px 16px;border-radius:7px;font-size:14px;line-height:1.5}
.sa-form-actions{display:flex;flex-wrap:wrap;gap:9px;margin-top:18px}
.sa-form-actions .sa-btn{min-height:42px}
@media(max-width:900px){
 .sa-admin-layout{grid-template-columns:1fr!important}
 .sa-admin-form-panel{min-height:0}
}
@media(max-width:700px){
 .sa-sidebar{width:190px;padding:16px 8px}
 .sa-main{margin-left:190px}
 .sa-content{padding:14px 12px 24px}
 .sa-topbar{padding:13px 14px;gap:8px}
 .sa-topbar h1{font-size:18px}
 .sa-user{font-size:12px}
 .sa-card{padding:17px 14px}
 .sa-nav a,.sa-sidebar form button{font-size:13px}
 .sa-table{min-width:680px}
}
</style>


    <style>
        .sa-main { margin-left:248px !important; }
        /* Standar sidebar lintas role: ukuran, tipografi, kategori, dan interaksi */
        .sa-sidebar {
            width:248px !important; min-width:248px !important; max-width:248px !important;
            box-sizing:border-box !important; padding:16px 12px 14px !important;
            background:#4b2d73 !important; color:#fff !important;
            font-family:Arial,sans-serif !important;
        }
        .sa-brand {
            min-height:72px !important; padding:0 4px 14px !important; margin:0 0 14px !important;
            display:flex !important; align-items:center !important; gap:11px !important;
            border-bottom:1px solid rgba(255,255,255,.16) !important;
            color:#fff !important; box-sizing:border-box !important;
        }
        .sa-logo {
            width:42px !important; height:42px !important; min-width:42px !important;
            flex:0 0 42px !important; object-fit:contain !important;
        }
        .sa-sidebar .admin-brand-text, .sa-sidebar .pelapor-brand strong, .sa-sidebar .satpam-brand strong,
        .sa-sidebar .sa-brand-name {
            color:#fff !important; font-size:14px !important; line-height:1.35 !important;
            font-weight:700 !important;
        }
        .sa-sidebar .admin-brand small, .sa-sidebar .pelapor-brand small, .sa-sidebar .satpam-brand small,
        .sa-sidebar .sa-brand-role {
            display:block !important; margin-top:3px !important; color:#e6d9f3 !important;
            font-size:11px !important; line-height:1.35 !important; font-weight:400 !important;
        }
        .sa-nav {
            display:flex !important; flex-direction:column !important; align-items:stretch !important;
            gap:0 !important; width:100% !important; margin:0 !important; padding:0 !important;
            min-width:0 !important;
        }
        .sa-sidebar .nav-group {
            display:flex !important; flex-direction:column !important; gap:3px !important;
            margin:0 0 12px !important; padding:0 !important;
        }
        .sa-sidebar .nav-group-title {
            padding:7px 10px 5px !important; margin:0 !important;
            color:#d8c8e8 !important; font-size:10px !important; line-height:1.3 !important;
            font-weight:700 !important; letter-spacing:.09em !important;
            text-transform:uppercase !important;
        }
        .sa-nav a, .sa-nav button {
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
        .sa-nav a:hover, .sa-nav a.active, .sa-nav button:hover {
            background:#7040a5 !important; color:#fff !important;
        }
        .sa-sidebar .sidebar-logout {
            display:block !important; width:100% !important; margin:12px 0 0 !important;
            padding:12px 0 0 !important; border-top:1px solid rgba(255,255,255,.16) !important;
        }
        .sa-sidebar > form:not(.sidebar-logout) {
            display:block !important; width:100% !important; margin:12px 0 0 !important;
            padding:12px 0 0 !important; border-top:1px solid rgba(255,255,255,.16) !important;
        }
        .sa-sidebar .sidebar-logout button, .sa-sidebar > form:not(.sidebar-logout) button {
            display:flex !important; align-items:center !important; width:100% !important;
            min-height:40px !important; padding:9px 11px !important; margin:0 !important;
            border:0 !important; border-radius:7px !important; background:transparent !important;
            color:#f8f5fb !important; text-align:left !important; cursor:pointer !important;
            font:500 13px/1.35 Arial,sans-serif !important; box-shadow:none !important;
        }
        .sa-sidebar .sidebar-logout button:hover, .sa-sidebar > form:not(.sidebar-logout) button:hover {
            background:#7040a5 !important; color:#fff !important;
        }
        @media(max-width:760px) {
            .sa-sidebar {
                position:relative !important; top:auto !important; bottom:auto !important; left:auto !important;
                width:100% !important; min-width:0 !important; max-width:none !important;
                height:auto !important; min-height:0 !important; max-height:none !important;
                overflow:visible !important; padding:12px !important;
            }
            .sa-nav { display:grid !important; grid-template-columns:repeat(auto-fit,minmax(145px,1fr)) !important; gap:8px !important; }
            .sa-sidebar .nav-group { margin:0 0 8px !important; }
            .sa-sidebar .nav-group-title { padding:5px 8px !important; }
            .sa-sidebar .sidebar-logout, .sa-sidebar > form:not(.sidebar-logout) {
                margin-top:8px !important; padding-top:8px !important;
            }
            .sa-main { margin-left:0 !important; }
        }
    </style>



    <style>
        /* Pagination riwayat aktivitas Super Admin */
        .sa-content .sa-pagination { margin-top:18px; }
        .sa-content .sa-pagination-nav { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px 18px; width:100%; font-family:Arial,sans-serif; }
        .sa-content .sa-pagination-info { color:#64748b; font-size:13px; line-height:1.5; }
        .sa-content .sa-pagination-list { display:flex; flex-wrap:wrap; align-items:center; gap:6px; }
        .sa-content .sa-pagination-list a, .sa-content .sa-pagination-list span { box-sizing:border-box; }
        .sa-content .sa-page-control, .sa-content .sa-page-number { display:inline-flex; align-items:center; justify-content:center; min-height:34px; padding:0 11px; border:1px solid #e2d8ec; border-radius:8px; background:#fff; color:#5b347d; font-size:13px; font-weight:600; line-height:1; text-decoration:none; transition:background .15s ease,border-color .15s ease,color .15s ease; }
        .sa-content .sa-page-number { min-width:34px; padding:0 9px; }
        .sa-content a.sa-page-control:hover, .sa-content a.sa-page-number:hover { border-color:#8b5ab5; background:#f7f1fc; color:#4b246e; }
        .sa-content .sa-page-number.is-active { border-color:#7040a5; background:#7040a5; color:#fff; cursor:default; }
        .sa-content .sa-page-control.is-disabled, .sa-content .sa-page-ellipsis { color:#a1a1aa; cursor:not-allowed; }
        .sa-content .sa-page-control.is-disabled { background:#f8fafc; border-color:#e5e7eb; }
        @media(max-width:600px) { .sa-content .sa-pagination-nav { align-items:flex-start; flex-direction:column; } .sa-content .sa-pagination-list { gap:5px; } }
            /* Standar tombol hapus Super Admin */
        .sa-content button.btn-delete,
        .sa-content .btn-delete {
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
        .sa-content button.btn-delete:hover,
        .sa-content .btn-delete:hover {
            background: #a91f1f !important;
            border-color: #941b1b !important;
            color: #fff !important;
        }
        .sa-content button.btn-delete:focus-visible,
        .sa-content .btn-delete:focus-visible {
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
    <div class="sa-shell">

        @include('super-admin.partials.sidebar')

        <main class="sa-main">

            <header class="sa-topbar">
                <h1>@yield('heading', 'Super Admin')</h1>

                <div class="sa-user">
                    Super Admin | {{ session('auth.nama', 'Super Admin') }}
                </div>
            </header>

            <section class="sa-content">

                @if (session('success'))
                    <div class="sa-alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="sa-alert sa-alert-error">
                        {{ session('error') }}
                    </div>
                @endif

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
