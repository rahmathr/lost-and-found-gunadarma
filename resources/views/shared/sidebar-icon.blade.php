@php($iconName = $name ?? 'circle')
<svg class="lf-sidebar-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
    @switch($iconName)
        @case('dashboard')<rect x="3" y="3" width="8" height="8" rx="1.5"/><rect x="13" y="3" width="8" height="5" rx="1.5"/><rect x="13" y="10" width="8" height="11" rx="1.5"/><rect x="3" y="13" width="8" height="8" rx="1.5"/>@break
        @case('university')<path d="m3 9 9-6 9 6"/><path d="M4 10h16M5 10v9m4-9v9m6-9v9m4-9v9M3 21h18M2 19h20"/>@break
        @case('users')<path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>@break
        @case('history')<path d="M3 12a9 9 0 1 0 2.64-6.36L3 8"/><path d="M3 3v5h5m4-1v5l3 2"/>@break
        @case('inbox')<path d="M4 4h16l1 11h-6l-2 3h-2l-2-3H3L4 4Z"/><path d="M3 15h6l2 3h2l2-3h6"/>@break
        @case('package-plus')<path d="m12 3 9 5v8l-9 5-9-5V8l9-5Z"/><path d="m3.3 8.2 8.7 4.9 8.7-4.9M12 13v8M12 7v4m-2-2h4"/>@break
        @case('file-text')<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6M8 13h8m-8 4h8"/>@break
        @case('shield-check')<path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/><path d="m9 12 2 2 4-4"/>@break
        @case('handshake')<path d="m11 17 2 2a2 2 0 0 0 3-3l-3-3M8 13l5 5a2 2 0 0 0 3-3l-4-4"/><path d="m2 12 5-5 5 1 2-1 6 5-4 4M2 12l4 7a2 2 0 0 0 3-2l-2-3M22 12l-3 5"/>@break
        @case('package-check')<path d="m12 3 9 5v8l-9 5-9-5V8l9-5Z"/><path d="m3.3 8.2 8.7 4.9 8.7-4.9M12 13v8m-3-11 2 2 4-4"/>@break
        @case('file-plus')<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6M12 18v-6m-3 3h6"/>@break
        @case('search')<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>@break
        @case('clipboard-list')<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4.5V3h6v1.5M9 10h6m-6 4h6m-6 4h3"/>@break
        @case('log-out')<path d="M10 17l5-5-5-5m5 5H3"/><path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>@break
        @default<circle cx="12" cy="12" r="8"/>
    @endswitch
</svg>
