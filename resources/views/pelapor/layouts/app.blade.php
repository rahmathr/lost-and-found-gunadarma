<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Area Pelapor - Lost &amp; Found Gundar')</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            font-family: Arial, sans-serif;
            color: #30283a;
            background: #f7f5fa;
        }

        .pelapor-shell {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .pelapor-sidebar {
            width: 240px;
            flex: 0 0 240px;
            background: #4b2d73;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        .pelapor-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 14px;
            min-height: 82px;
            border-bottom: 1px solid rgba(255,255,255,.14);
        }

        .pelapor-brand img {
            width: 42px;
            height: 42px;
            object-fit: contain;
            background: transparent;
            border: 0;
            border-radius: 0;
            padding: 0;
            display: block;
        }

        .pelapor-brand strong {
            display: block;
            font-size: 13px;
            line-height: 1.35;
        }

        .pelapor-brand small {
            display: block;
            margin-top: 3px;
            color: #e6d9f3;
            font-size: 10px;
        }

        .pelapor-nav {
            padding: 12px 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .pelapor-nav a,
        .pelapor-nav button {
            display: block;
            width: 100%;
            padding: 11px 12px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #fff;
            text-align: left;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .pelapor-nav a:hover,
        .pelapor-nav a.active,
        .pelapor-nav button:hover {
            background: #7040a5;
        }

        .pelapor-nav form {
            margin-top: 10px;
        }

        .pelapor-main {
            flex: 1;
            min-width: 0;
        }

        .pelapor-topbar {
            min-height: 64px;
            padding: 12px 24px;
            background: #fff;
            border-bottom: 1px solid #e7e0ef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
        }

        .pelapor-topbar h1 {
            font-size: 18px;
            margin: 0;
            color: #392451;
        }

        .pelapor-user {
            font-size: 12px;
            color: #6c6177;
            text-align: right;
        }

        .pelapor-content {
            padding: 24px 26px 32px;
            min-width: 0;
        }

        .pelapor-content table {
            max-width: 100%;
        }

        .pelapor-content input,
        .pelapor-content select,
        .pelapor-content textarea {
            max-width: 100%;
        }

        .pelapor-content .container {
            margin: 0 auto !important;
            max-width: 1100px;
        }

        .pelapor-content .page-content {
            padding: 0 !important;
        }

        .pelapor-page-surface {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            font-size: 14px;
            line-height: 1.55;
        }

        .pelapor-page-surface > h1 {
            font-size: 26px;
            line-height: 1.3;
            font-weight: 700;
            color: #30283a;
            margin: 0 0 8px;
        }

        .pelapor-page-surface > p {
            line-height: 1.55;
            margin: 0 0 14px;
            color: #4b4452;
        }

        .pelapor-page-surface > .container,
        .pelapor-page-surface > .page-panel {
            max-width: none;
            width: 100%;
            margin: 0;
            background: #fff;
            padding: 22px 24px;
            border: 1px solid #eee8f2;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(35,22,49,.06);
        }

        .pelapor-page-surface table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0 0;
            background: #fff;
            font-size: 14px;
        }

        .pelapor-page-surface th {
            background: #f7f8fb !important;
            color: #30283a;
            font-weight: 700;
            text-align: left;
        }

        .pelapor-page-surface th,
        .pelapor-page-surface td {
            padding: 12px 13px;
            border: 1px solid #e5e1e9 !important;
            vertical-align: middle;
        }

        .pelapor-page-surface tbody tr:hover {
            background: #faf8fc;
        }

        /* Tombol */
        .pelapor-page-surface a.primary,
        .pelapor-page-surface a.secondary,
        .pelapor-page-surface a.button,
        .pelapor-page-surface a.action-button,
        .pelapor-page-surface button.primary,
        .pelapor-page-surface button[type=submit] {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 9px 14px;
            border: 0;
            border-radius: 6px;
            text-decoration: none;
            font: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .pelapor-page-surface a.primary,
        .pelapor-page-surface a.button,
        .pelapor-page-surface a.action-button,
        .pelapor-page-surface button.primary,
        .pelapor-page-surface button[type=submit] {
            background: #4b2d73;
            color: #fff;
        }

        .pelapor-page-surface a.secondary {
            background: #eef0f4;
            color: #393341;
        }

        .pelapor-page-surface a.primary:hover,
        .pelapor-page-surface a.button:hover,
        .pelapor-page-surface a.action-button:hover,
        .pelapor-page-surface button[type=submit]:hover {
            background: #62408b;
        }

        .pelapor-page-surface a.secondary:hover {
            background: #e1dce8;
        }

        .pelapor-page-surface p:has(>a) {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 14px 0;
        }

        .pelapor-page-surface .pagination {
            margin-top: 18px;
        }

        .pelapor-page-surface .alert,
        .pelapor-page-surface .success {
            border-radius: 7px;
        }

        /* Tipografi */
        .pelapor-page-surface h1,
        .pelapor-page-surface .page-title {
            font-size: 24px !important;
            line-height: 1.3;
        }

        .pelapor-page-surface h2 {
            font-size: 19px !important;
            line-height: 1.35;
        }

        .pelapor-page-surface h3,
        .pelapor-page-surface .section-title {
            font-size: 16px !important;
            line-height: 1.4;
        }

        .pelapor-page-surface p,
        .pelapor-page-surface li,
        .pelapor-page-surface label,
        .pelapor-page-surface .tips-content,
        .pelapor-page-surface .product-info,
        .pelapor-page-surface .info,
        .pelapor-page-surface .checkbox,
        .pelapor-page-surface .alert,
        .pelapor-page-surface .notification,
        .pelapor-page-surface .field-error {
            font-size: 14px !important;
            line-height: 1.55;
        }

        .pelapor-page-surface input,
        .pelapor-page-surface select,
        .pelapor-page-surface textarea {
            font-size: 14px !important;
            min-height: 40px;
        }

        .pelapor-page-surface textarea {
            min-height: 110px;
        }

        .pelapor-page-surface table {
            font-size: 14px !important;
        }

        .pelapor-page-surface th,
        .pelapor-page-surface td {
            font-size: 14px !important;
            line-height: 1.45;
        }

        .pelapor-page-surface .status,
        .pelapor-page-surface .action-button,
        .pelapor-page-surface .pagination,
        .pelapor-page-surface .breadcrumb,
        .pelapor-page-surface .product-image {
            font-size: 13px !important;
        }

        .pelapor-page-surface .form-panel,
        .pelapor-page-surface .tips-panel,
        .pelapor-page-surface .panel {
            border: 1px solid #eee8f2;
            border-radius: 9px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(35,22,49,.05);
        }

        .pelapor-page-surface .form-panel,
        .pelapor-page-surface .tips-content,
        .pelapor-page-surface .product-content {
            padding: 18px;
        }

        .pelapor-page-surface .tips-title,
        .pelapor-page-surface .panel-title {
            font-size: 15px !important;
            padding: 12px 14px;
        }

        .pelapor-page-surface .form-actions,
        .pelapor-page-surface .buttons {
            flex-wrap: wrap;
        }

        /* Responsif */
        @media(max-width:760px) {
            .pelapor-shell {
                display: block;
            }

            .pelapor-sidebar {
                width: 100%;
                min-height: 0;
            }

            .pelapor-brand {
                min-height: 66px;
            }

            .pelapor-nav {
                flex-direction: row;
                flex-wrap: wrap;
                padding: 10px;
            }

            .pelapor-nav a,
            .pelapor-nav button {
                width: auto;
                flex: 1 1 auto;
                padding: 9px 10px;
            }

            .pelapor-nav form {
                margin: 0 0 0 auto;
            }

            .pelapor-main {
                width: 100%;
                margin: 0;
            }

            .pelapor-topbar {
                min-height: 54px;
                align-items: flex-start;
                flex-direction: column;
                padding: 12px 16px;
            }

            .pelapor-user {
                text-align: left;
            }

            .pelapor-content {
                padding: 16px 12px 24px;
            }

            .pelapor-page-surface > .container,
            .pelapor-page-surface > .page-panel {
                padding: 16px 12px;
                overflow-x: auto;
            }

            .pelapor-page-surface table {
                min-width: 680px;
            }

            .pelapor-content .statistics {
                grid-template-columns: repeat(2,minmax(0,1fr)) !important;
            }

            .pelapor-content .page-layout,
            .pelapor-content .summary-grid {
                grid-template-columns: 1fr !important;
            }

            .pelapor-page-surface h1,
            .pelapor-page-surface .page-title {
                font-size: 21px !important;
            }

            .pelapor-page-surface h2 {
                font-size: 18px !important;
            }

            .pelapor-page-surface p,
            .pelapor-page-surface li,
            .pelapor-page-surface label,
            .pelapor-page-surface th,
            .pelapor-page-surface td {
                font-size: 13px !important;
            }
        }
    </style>

    @stack('styles')

    <style>
        /* Area konten Pelapor: semua aturan dibatasi agar tidak memengaruhi sidebar/layout */
        .pelapor-page-surface { color:#30283a; }
        .pelapor-page-surface > .pelapor-content-panel { width:100%; min-width:0; padding:22px; background:#fff; border:1px solid #eee8f2; border-radius:10px; box-shadow:0 2px 8px rgba(35,22,49,.05); }
        .pelapor-page-surface h1,.pelapor-page-surface h2,.pelapor-page-surface h3 { color:#392451; font-weight:700; }
        .pelapor-page-surface h1 { font-size:25px; line-height:1.3; margin:0 0 10px; }
        .pelapor-page-surface h2 { font-size:19px; line-height:1.4; margin:0 0 14px; }
        .pelapor-page-surface h3 { font-size:16px; line-height:1.4; margin:0 0 14px; }
        .pelapor-page-surface p { line-height:1.6; }
        .pelapor-page-surface .header { margin:0 0 22px; }
        .pelapor-page-surface .header p { color:#6b6273; margin-top:5px; }
        .pelapor-page-surface .statistics { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:14px; margin:0 0 22px; }
        .pelapor-page-surface .stat-card { min-width:0; padding:20px; background:#fff; border:1px solid #eee8f2; border-radius:10px; box-shadow:0 2px 8px rgba(35,22,49,.05); }
        .pelapor-page-surface .stat-card p { color:#71677c; font-size:13px; margin:0 0 9px; }
        .pelapor-page-surface .stat-card h2 { font-size:27px; margin:0; }
        .pelapor-page-surface .section { min-width:0; padding:20px; margin:0 0 18px; background:#fff; border:1px solid #eee8f2; border-radius:10px; box-shadow:0 2px 8px rgba(35,22,49,.05); overflow:hidden; }
        .pelapor-page-surface .section h2 { margin-bottom:14px; }
        .pelapor-page-surface .empty { color:#746b7d; padding:12px 0; }
        .pelapor-page-surface .page-heading { display:flex; justify-content:space-between; align-items:center; gap:14px; margin:0 0 18px; }
        .pelapor-page-surface .page-heading h1 { margin:0; }
        .pelapor-page-surface .primary-button { display:inline-flex; align-items:center; justify-content:center; min-height:40px; padding:9px 15px; border:1px solid #4b2d73; border-radius:7px; background:#4b2d73; color:#fff; text-decoration:none; font-size:14px; font-weight:600; }
        .pelapor-page-surface .summary-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; margin:0 0 22px; }
        .pelapor-page-surface .summary-card { min-width:0; padding:16px; border:1px solid #eee8f2; border-radius:9px; background:#fff; box-shadow:0 2px 8px rgba(35,22,49,.04); }
        .pelapor-page-surface .summary-number { color:#4b2d73; font-size:25px; font-weight:700; margin:0 0 4px; }
        .pelapor-page-surface .summary-label { color:#71677c; font-size:13px; }
        .pelapor-page-surface .section-title { margin:0 0 10px; font-size:17px; }
        .pelapor-page-surface .table-wrapper { width:100%; overflow-x:auto; margin:0 0 24px; border:1px solid #e8e2ed; border-radius:8px; }
        .pelapor-page-surface table { width:100%; min-width:680px; margin:0; border-collapse:collapse; background:#fff; font-size:13px; }
        .pelapor-page-surface th,.pelapor-page-surface td { padding:11px 12px; border:1px solid #e9e4ed; text-align:left; vertical-align:middle; white-space:normal; }
        .pelapor-page-surface th { background:#f5f1f9 !important; color:#443451; font-weight:700; }
        .pelapor-page-surface tbody tr:nth-child(even) { background:#fcfbfd; }
        .pelapor-page-surface tbody tr:hover { background:#f8f4fb; }
        .pelapor-page-surface .status { display:inline-flex; align-items:center; justify-content:center; min-width:82px; padding:5px 9px; border:1px solid #ddd; border-radius:20px; font-size:12px; font-weight:600; white-space:normal; }
        .pelapor-page-surface .status-pending { background:#fff6df; border-color:#f0d28a; color:#805b12; }
        .pelapor-page-surface .status-approved { background:#e8f6ec; border-color:#a8d8b4; color:#246b3b; }
        .pelapor-page-surface .status-rejected { background:#fdecec; border-color:#efb4b4; color:#9a2929; }
        .pelapor-page-surface .status-other { background:#f2edfa; border-color:#d8c8eb; color:#593b7b; }
        .pelapor-page-surface .action-button { display:inline-flex; align-items:center; justify-content:center; min-height:34px; padding:7px 11px; border-radius:6px; background:#f0eaf7; color:#4b2d73; text-decoration:none; font-size:12px; font-weight:600; }
        .pelapor-page-surface .action-button:hover { background:#e5d9f1; }
        .pelapor-page-surface .breadcrumb { margin:0 0 12px; color:#756b80; font-size:13px; }
        .pelapor-page-surface .breadcrumb a { color:#5b3c7d; text-decoration:none; }
        .pelapor-page-surface .page-title { margin:0 0 18px; }
        .pelapor-page-surface .page-layout { display:grid; grid-template-columns:minmax(0,1.7fr) minmax(250px,.9fr); gap:18px; align-items:start; margin:0; }
        .pelapor-page-surface .form-panel,.pelapor-page-surface .tips-panel,.pelapor-page-surface .panel { min-width:0; background:#fff; border:1px solid #eee8f2; border-radius:10px; box-shadow:0 2px 8px rgba(35,22,49,.05); }
        .pelapor-page-surface .form-panel { padding:22px; }
        .pelapor-page-surface .tips-panel { overflow:hidden; }
        .pelapor-page-surface .tips-title,.pelapor-page-surface .panel-title { padding:13px 16px; background:#f5f1f9; border-bottom:1px solid #e8e0ef; color:#443451; font-size:15px; font-weight:700; }
        .pelapor-page-surface .tips-content,.pelapor-page-surface .product-content { padding:16px; color:#5d5368; }
        .pelapor-page-surface .tips-content ul { margin:0; padding-left:20px; }
        .pelapor-page-surface .tips-content li { margin:0 0 9px; }
        .pelapor-page-surface .form-group { min-width:0; margin:0 0 17px; }
        .pelapor-page-surface .form-row { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; }
        .pelapor-page-surface label { display:block; margin:0 0 7px; color:#443b4d; font-size:13px; font-weight:600; }
        .pelapor-page-surface input:not([type=checkbox]):not([type=radio]),.pelapor-page-surface select,.pelapor-page-surface textarea { display:block; width:100%; max-width:100%; min-height:42px; padding:10px 12px; border:1px solid #d8d1df; border-radius:7px; background:#fff; color:#30283a; font:14px Arial,sans-serif; }
        .pelapor-page-surface input[type=file] { min-height:auto; padding:9px; background:#faf9fc; }
        .pelapor-page-surface textarea { min-height:120px; resize:vertical; }
        .pelapor-page-surface input:focus,.pelapor-page-surface select:focus,.pelapor-page-surface textarea:focus { outline:3px solid rgba(112,64,165,.14); border-color:#7040a5; }
        .pelapor-page-surface input[type=checkbox],.pelapor-page-surface input[type=radio] { width:auto; min-height:0; accent-color:#7040a5; }
        .pelapor-page-surface small { display:block; margin-top:6px; color:#746b7d; font-size:12px; line-height:1.5; }
        .pelapor-page-surface .field-error { margin-top:6px; color:#b42318; font-size:12px; }
        .pelapor-page-surface .form-actions,.pelapor-page-surface .buttons { display:flex; flex-wrap:wrap; align-items:center; gap:9px; margin-top:18px; }
        .pelapor-page-surface .button,.pelapor-page-surface a.primary,.pelapor-page-surface a.secondary,.pelapor-page-surface button.primary,.pelapor-page-surface button[type=submit] { display:inline-flex; align-items:center; justify-content:center; min-height:40px; padding:9px 15px; border:1px solid transparent; border-radius:7px; font:600 14px Arial,sans-serif; text-decoration:none; cursor:pointer; }
        .pelapor-page-surface .button-primary,.pelapor-page-surface a.primary,.pelapor-page-surface button.primary,.pelapor-page-surface button[type=submit] { background:#4b2d73; border-color:#4b2d73; color:#fff; }
        .pelapor-page-surface .button-primary:hover,.pelapor-page-surface a.primary:hover,.pelapor-page-surface button.primary:hover,.pelapor-page-surface button[type=submit]:hover { background:#62408b; }
        .pelapor-page-surface .button-secondary,.pelapor-page-surface a.secondary,.pelapor-page-surface .btn { background:#f1edf5; border-color:#e2d9eb; color:#49365e; }
        .pelapor-page-surface .button-secondary:hover,.pelapor-page-surface a.secondary:hover,.pelapor-page-surface .btn:hover { background:#e7dfef; }
        .pelapor-page-surface .alert,.pelapor-page-surface .alert-error,.pelapor-page-surface .notification,.pelapor-page-surface .success,.pelapor-page-surface .info { padding:12px 14px; margin:0 0 15px; border:1px solid #e5d9ef; border-radius:8px; background:#f7f1fc; color:#49365e; font-size:13px; line-height:1.55; }
        .pelapor-page-surface .alert-error,.pelapor-page-surface .alert.error { background:#fff1f0; border-color:#f2c2bf; color:#9f2d26; }
        .pelapor-page-surface .alert-success,.pelapor-page-surface .alert.success,.pelapor-page-surface .success { background:#edf8f0; border-color:#b9dfc2; color:#27643a; }
        .pelapor-page-surface .info { background:#f5f0fb; border-color:#dfd1ee; }
        .pelapor-page-surface .pagination { display:flex; flex-wrap:wrap; gap:5px; margin-top:16px; }
        .pelapor-page-surface .pagination a,.pelapor-page-surface .pagination span { display:inline-flex; align-items:center; justify-content:center; min-width:34px; min-height:34px; padding:6px 10px; border:1px solid #e4dceb; border-radius:6px; text-decoration:none; color:#4b2d73; background:#fff; }
        .pelapor-page-surface .pagination .active span { background:#4b2d73; color:#fff; border-color:#4b2d73; }
        .pelapor-page-surface .content { display:grid; grid-template-columns:minmax(250px,.8fr) minmax(0,1.4fr); gap:18px; align-items:start; }
        .pelapor-page-surface .panel { overflow:hidden; }
        .pelapor-page-surface .form-panel h3 { margin:0 0 15px; }
        .pelapor-page-surface .product-image { display:flex; align-items:center; justify-content:center; min-height:170px; padding:12px; background:#f6f3f8; border:1px dashed #d8cde2; border-radius:8px; color:#756b80; text-align:center; }
        .pelapor-page-surface .product-name { margin:12px 0 8px; font-size:16px; font-weight:700; }
        .pelapor-page-surface .product-info { color:#62596b; line-height:1.65; }
        .pelapor-page-surface .checkbox { display:flex; align-items:flex-start; gap:9px; margin:14px 0; }
        .pelapor-page-surface .checkbox label { margin:0; font-weight:400; }
        .pelapor-page-surface .btn-delete { display:inline-flex; align-items:center; justify-content:center; min-height:36px; padding:8px 12px; border:1px solid #b42318; border-radius:6px; background:#c62828; color:#fff; font-size:12px; font-weight:600; cursor:pointer; }
        @media(max-width:1000px) { .pelapor-page-surface .statistics { grid-template-columns:repeat(2,minmax(0,1fr)); } }
        @media(max-width:760px) {
            .pelapor-page-surface h1 { font-size:22px; }
            .pelapor-page-surface .statistics { grid-template-columns:repeat(2,minmax(0,1fr)); }
            .pelapor-page-surface .summary-grid { grid-template-columns:1fr; }
            .pelapor-page-surface .page-layout,.pelapor-page-surface .content { grid-template-columns:1fr; }
            .pelapor-page-surface .page-heading { align-items:flex-start; flex-direction:column; }
            .pelapor-page-surface .form-panel { padding:16px; }
            .pelapor-page-surface .form-row { grid-template-columns:1fr; gap:0; }
            .pelapor-page-surface .section { padding:15px; }
            .pelapor-page-surface > .pelapor-content-panel { padding:16px; }
        }
        @media(max-width:480px) {
            .pelapor-page-surface .statistics { grid-template-columns:1fr; }
            .pelapor-page-surface .form-actions,.pelapor-page-surface .buttons { align-items:stretch; flex-direction:column; }
            .pelapor-page-surface .form-actions > *, .pelapor-page-surface .buttons > * { width:100%; }
            .pelapor-page-surface .primary-button { width:100%; }
        }
    </style>

    {{-- Pengunci posisi layout: harus berada setelah seluruh CSS halaman --}}
    <style>
        html,
        body {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            overscroll-behavior-y: none;
        }

        body {
            position: relative !important;
            top: 0 !important;
            transform: none !important;
            overflow-x: hidden;
        }

        .pelapor-shell {
            position: relative !important;
            top: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            transform: none !important;
        }

        .pelapor-sidebar,
        .pelapor-main,
        .pelapor-topbar {
            margin-top: 0 !important;
        }

        .pelapor-content {
            min-width: 0;
        }
    </style>

    <style>
        /* Standar sidebar lintas role: ukuran, tipografi, kategori, dan interaksi */
        .pelapor-sidebar {
            width:248px !important; min-width:248px !important; max-width:248px !important;
            box-sizing:border-box !important; padding:16px 12px 14px !important;
            background:#4b2d73 !important; color:#fff !important;
            font-family:Arial,sans-serif !important;
        }
        .pelapor-brand {
            min-height:72px !important; padding:0 4px 14px !important; margin:0 0 14px !important;
            display:flex !important; align-items:center !important; gap:11px !important;
            border-bottom:1px solid rgba(255,255,255,.16) !important;
            color:#fff !important; box-sizing:border-box !important;
        }
        .pelapor-brand img {
            width:42px !important; height:42px !important; min-width:42px !important;
            flex:0 0 42px !important; object-fit:contain !important;
        }
        .pelapor-sidebar .admin-brand-text, .pelapor-sidebar .pelapor-brand strong, .pelapor-sidebar .satpam-brand strong,
        .pelapor-sidebar .sa-brand-name {
            color:#fff !important; font-size:14px !important; line-height:1.35 !important;
            font-weight:700 !important;
        }
        .pelapor-sidebar .admin-brand small, .pelapor-sidebar .pelapor-brand small, .pelapor-sidebar .satpam-brand small,
        .pelapor-sidebar .sa-brand-role {
            display:block !important; margin-top:3px !important; color:#e6d9f3 !important;
            font-size:11px !important; line-height:1.35 !important; font-weight:400 !important;
        }
        .pelapor-nav {
            display:flex !important; flex-direction:column !important; align-items:stretch !important;
            gap:0 !important; width:100% !important; margin:0 !important; padding:0 !important;
            min-width:0 !important;
        }
        .pelapor-sidebar .nav-group {
            display:flex !important; flex-direction:column !important; gap:3px !important;
            margin:0 0 12px !important; padding:0 !important;
        }
        .pelapor-sidebar .nav-group-title {
            padding:7px 10px 5px !important; margin:0 !important;
            color:#d8c8e8 !important; font-size:10px !important; line-height:1.3 !important;
            font-weight:700 !important; letter-spacing:.09em !important;
            text-transform:uppercase !important;
        }
        .pelapor-nav a, .pelapor-nav button {
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
        .pelapor-nav a:hover, .pelapor-nav a.active, .pelapor-nav button:hover {
            background:#7040a5 !important; color:#fff !important;
        }
        .pelapor-sidebar .sidebar-logout {
            display:block !important; width:100% !important; margin:12px 0 0 !important;
            padding:12px 0 0 !important; border-top:1px solid rgba(255,255,255,.16) !important;
        }
        .pelapor-sidebar > form:not(.sidebar-logout) {
            display:block !important; width:100% !important; margin:12px 0 0 !important;
            padding:12px 0 0 !important; border-top:1px solid rgba(255,255,255,.16) !important;
        }
        .pelapor-sidebar .sidebar-logout button, .pelapor-sidebar > form:not(.sidebar-logout) button {
            display:flex !important; align-items:center !important; width:100% !important;
            min-height:40px !important; padding:9px 11px !important; margin:0 !important;
            border:0 !important; border-radius:7px !important; background:transparent !important;
            color:#f8f5fb !important; text-align:left !important; cursor:pointer !important;
            font:500 13px/1.35 Arial,sans-serif !important; box-shadow:none !important;
        }
        .pelapor-sidebar .sidebar-logout button:hover, .pelapor-sidebar > form:not(.sidebar-logout) button:hover {
            background:#7040a5 !important; color:#fff !important;
        }
        @media(max-width:760px) {
            .pelapor-sidebar {
                position:relative !important; top:auto !important; bottom:auto !important; left:auto !important;
                width:100% !important; min-width:0 !important; max-width:none !important;
                height:auto !important; min-height:0 !important; max-height:none !important;
                overflow:visible !important; padding:12px !important;
            }
            .pelapor-nav { display:grid !important; grid-template-columns:repeat(auto-fit,minmax(145px,1fr)) !important; gap:8px !important; }
            .pelapor-sidebar .nav-group { margin:0 0 8px !important; }
            .pelapor-sidebar .nav-group-title { padding:5px 8px !important; }
            .pelapor-sidebar .sidebar-logout, .pelapor-sidebar > form:not(.sidebar-logout) {
                margin-top:8px !important; padding-top:8px !important;
            }
            .pelapor-main { margin-left:0 !important; }
        }
            /* Standar tombol hapus Pelapor */
        .pelapor-content button.btn-delete,
        .pelapor-content .btn-delete {
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
        .pelapor-content button.btn-delete:hover,
        .pelapor-content .btn-delete:hover {
            background: #a91f1f !important;
            border-color: #941b1b !important;
            color: #fff !important;
        }
        .pelapor-content button.btn-delete:focus-visible,
        .pelapor-content .btn-delete:focus-visible {
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
<div class="pelapor-shell">

    <aside class="pelapor-sidebar">
        <div class="pelapor-brand">
            <img src="{{ asset('images/gunadarma-logo.png') }}" alt="Logo Universitas Gunadarma">

            <div>
                <strong>Lost &amp; Found Gundar</strong>
                <small>Pelapor / Mahasiswa</small>
            </div>
        </div>

        <nav class="pelapor-nav" aria-label="Navigasi Pelapor">
            <div class="nav-group">
                <div class="nav-group-title">Ringkasan</div>
                <a href="{{ route('dashboard.pelapor') }}" class="{{ request()->routeIs('dashboard.pelapor') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'dashboard']) Dashboard</a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Laporan Saya</div>
                <a href="{{ route('pelapor.laporan-kehilangan.index') }}" class="{{ request()->routeIs('pelapor.laporan-kehilangan.*') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'file-text']) Laporan &amp; Klaim Saya</a>
                <a href="{{ route('pelapor.laporan-kehilangan.create') }}" class="{{ request()->routeIs('pelapor.laporan-kehilangan.create') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'file-plus']) Buat Laporan</a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Pencarian &amp; Klaim</div>
                <a href="{{ route('pelapor.klaim.index') }}" class="{{ request()->routeIs('pelapor.klaim.index','pelapor.klaim.show') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'search']) Cari Barang</a>
                <a href="{{ route('pelapor.klaim.riwayat') }}" class="{{ request()->routeIs('pelapor.klaim.riwayat') ? 'active' : '' }}">@include('shared.sidebar-icon', ['name' => 'history']) Riwayat Klaim</a>
            </div>

            <form class="sidebar-logout" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">@include('shared.sidebar-icon', ['name' => 'log-out']) Keluar</button>
            </form>
        </nav>
    </aside>

    <main class="pelapor-main">

        <header class="pelapor-topbar">
            <h1>@yield('heading')</h1>

            <div class="pelapor-user">
                {{ session('auth.nama', 'Pelapor') }} · Area Pelapor
            </div>
        </header>

        <div class="pelapor-content">
            <div class="pelapor-page-surface">
                @yield('content')
            </div>
        </div>

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
