<x-tenant-layout :title="$concern->subject">
    <div class="bg-white rounded-xl border border-slate-200 p-6 max-w-2xl space-y-5">
        <div class="flex items-center gap-2">
            <span class="text-xs px-2 py-0.5 rounded-full
                {{ $concern->priority === 'high' ? 'bg-red-100 text-red-700' : ($concern->priority === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                {{ ucfirst($concern->priority) }} priority
            </span>
            <span class="text-xs px-2 py-0.5 rounded-full
                {{ $concern->status === 'resolved' ? 'bg-green-100 text-green-700' : ($concern->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                {{ ucfirst(str_replace('_', ' ', $concern->status)) }}
            </span>
            <span class="text-xs text-slate-400">Reported {{ $concern->reported_date?->format('M j, Y') }}</span>
        </div>

        <div>
            <div class="text-xs font-semibold text-slate-500 uppercase mb-1">Description</div>
            <p class="text-sm text-slate-700 whitespace-pre-line">{{ $concern->description ?: 'No additional details provided.' }}</p>
        </div>

        <div class="pt-4 border-t border-slate-100">
            <div class="text-xs font-semibold text-slate-500 uppercase mb-1">Resolution from your property manager</div>
            @if ($concern->resolution)
                <p class="text-sm text-slate-700 whitespace-pre-line">{{ $concern->resolution }}</p>
                @if ($concern->resolved_date)
                    <div class="text-xs text-slate-400 mt-1">Resolved {{ $concern->resolved_date->format('M j, Y') }}</div>
                @endif
            @else
                <p class="text-sm text-slate-500">No response yet. We'll update this once your property manager reviews it.</p>
            @endif
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('tenant.concerns.index') }}" class="text-sm text-slate-600 hover:underline">&larr; Back to my concerns</a>
    </div>
</x-tenant-layout>
