<x-tenant-layout :title="$concern->subject">
    <div class="bg-white rounded-xl border border-[#e2e8f0] p-6 max-w-2xl space-y-5">
        <div class="flex items-center gap-2">
            <span class="text-xs px-2 py-0.5 rounded-full
                {{ $concern->priority === 'high' ? 'bg-[#f5dde1] text-[#7c2233]' : ($concern->priority === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-[#f1f5f9] text-[#475569]') }}">
                {{ ucfirst($concern->priority) }} priority
            </span>
            <x-badge :tone="$concern->status === 'resolved' ? 'positive' : ($concern->status === 'in_progress' ? 'warning' : 'neutral')">
                                {{ ucfirst(str_replace('_', ' ', $concern->status)) }}
                            </x-badge>
            <span class="text-xs text-[#94a3b8]">Reported {{ $concern->reported_date?->format('M j, Y') }}</span>
        </div>

        <div>
            <div class="text-xs font-semibold text-[#64748b] uppercase mb-1">Description</div>
            <p class="text-sm text-[#1e293b] whitespace-pre-line">{{ $concern->description ?: 'No additional details provided.' }}</p>
        </div>

        <div class="pt-4 border-t border-[#f1f5f9]">
            <div class="text-xs font-semibold text-[#64748b] uppercase mb-1">Resolution from your property manager</div>
            @if ($concern->resolution)
                <p class="text-sm text-[#1e293b] whitespace-pre-line">{{ $concern->resolution }}</p>
                @if ($concern->resolved_date)
                    <div class="text-xs text-[#94a3b8] mt-1">Resolved {{ $concern->resolved_date->format('M j, Y') }}</div>
                @endif
            @else
                <p class="text-sm text-[#64748b]">No response yet. We'll update this once your property manager reviews it.</p>
            @endif
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('tenant.concerns.index') }}" class="text-sm text-[#475569] hover:underline">&larr; Back to my concerns</a>
    </div>
</x-tenant-layout>
