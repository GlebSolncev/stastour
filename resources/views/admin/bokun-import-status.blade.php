@php($active = in_array($status, ['running', 'in_progress'], true))
<span class="bokun-import-status">
    @if($active)
        <span class="bokun-import-spinner" aria-hidden="true"></span>
    @endif
    {{ strtoupper(str_replace('_', ' ', $status)) }}
</span>

@once
    <style>
        .bokun-import-status { display: inline-flex; align-items: center; gap: .45rem; font-weight: 600; }
        .bokun-import-spinner { width: 1rem; height: 1rem; border: 2px solid rgba(13, 110, 253, .25); border-top-color: #0d6efd; border-radius: 50%; animation: bokun-import-spin .75s linear infinite; }
        @keyframes bokun-import-spin { to { transform: rotate(360deg); } }
    </style>
@endonce
