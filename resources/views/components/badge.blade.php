@props(['tone' => 'neutral'])
@php
    $classes = match ($tone) {
        'positive' => 'bg-[#0f172a] text-white font-semibold',
        'warning' => 'bg-amber-100 text-amber-700',
        'negative' => 'bg-[#f5dde1] text-[#7c2233]',
        default => 'bg-[#f1f5f9] text-[#475569]',
    };
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-full $classes"]) }}>
    @if ($tone === 'positive')
        <svg class="w-2.5 h-2.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12l5 5L20 6"/></svg>
    @endif
    {{ $slot }}
</span>
