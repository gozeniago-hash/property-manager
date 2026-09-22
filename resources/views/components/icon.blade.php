@props(['name'])
@php
    $paths = [
        'mark' => '<path d="M3 9.5L12 3l9 6.5"/><path d="M5 9.5V19a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V9.5"/>',
        'dashboard' => '<rect x="3" y="3" width="7" height="7" rx="1.3"/><rect x="14" y="3" width="7" height="7" rx="1.3"/><rect x="3" y="14" width="7" height="7" rx="1.3"/><rect x="14" y="14" width="7" height="7" rx="1.3"/>',
        'properties' => '<rect x="5" y="3" width="14" height="18" rx="1"/><path d="M9 7h1.5M13.5 7H15M9 11h1.5M13.5 11H15M9 15h1.5M13.5 15H15"/>',
        'units' => '<rect x="6" y="3" width="12" height="18" rx="1"/><circle cx="14.5" cy="12" r="1" fill="currentColor" stroke="none"/>',
        'tenants' => '<circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-4 3-6.5 7-6.5s7 2.5 7 6.5"/>',
        'bills' => '<path d="M6 3h12v17l-2-1.3-2 1.3-2-1.3-2 1.3-2-1.3-2 1.3V3z"/><path d="M9 8h6M9 12h6M9 16h3"/>',
        'concerns' => '<path d="M12 3.5 21 19H3L12 3.5z"/><path d="M12 10v4"/><circle cx="12" cy="16.5" r="0.9" fill="currentColor" stroke="none"/>',
        'expenses' => '<circle cx="12" cy="12" r="9"/><path d="M15 9.5a2.5 2.5 0 0 0-2.5-2H11a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-1.5a2.5 2.5 0 0 1-2.5-2"/><path d="M12 6v1.3M12 16.7V18"/>',
        'reports' => '<path d="M4 20V10M10 20V4M16 20v-7M4 20h16"/>',
        'logout' => '<path d="M9 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h4"/><path d="M14 15l4-4-4-4"/><path d="M18 11H9"/>',
        'check' => '<path d="M4 12l5 5L20 6"/>',
    ][$name] ?? '';
@endphp
<svg {{ $attributes->merge(['class' => 'w-[18px] h-[18px]', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => $name === 'check' ? '2.5' : '1.5', 'stroke-linecap' => 'round', 'stroke-linejoin' => 'round']) }}>{!! $paths !!}</svg>
