<x-layout title="Tenant Concerns">
    <div class="flex items-center justify-between mb-4">
        <div class="flex gap-2 text-sm">
            <a href="{{ route('concerns.index') }}" class="px-3 py-1.5 rounded-full {{ request('status') ? 'bg-white border border-[#e2e8f0] text-[#475569]' : 'bg-[#0f172a] text-white' }}">All</a>
            <a href="{{ route('concerns.index', ['status' => 'open']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'open' ? 'bg-[#0f172a] text-white' : 'bg-white border border-[#e2e8f0] text-[#475569]' }}">Open</a>
            <a href="{{ route('concerns.index', ['status' => 'in_progress']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'in_progress' ? 'bg-[#0f172a] text-white' : 'bg-white border border-[#e2e8f0] text-[#475569]' }}">In progress</a>
            <a href="{{ route('concerns.index', ['status' => 'resolved']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'resolved' ? 'bg-[#0f172a] text-white' : 'bg-white border border-[#e2e8f0] text-[#475569]' }}">Resolved</a>
        </div>
        <a href="{{ route('concerns.create') }}" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">
            + Log Concern
        </a>
    </div>

    <div class="bg-white rounded-xl border border-[#e2e8f0] overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#f8fafc] text-left text-xs uppercase text-[#64748b]">
                <tr>
                    <th class="px-5 py-3">Subject</th>
                    <th class="px-5 py-3">Tenant / Unit</th>
                    <th class="px-5 py-3">Priority</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Reported</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($concerns as $concern)
                    <tr>
                        <td class="px-5 py-3 font-medium text-[#1e293b]">{{ $concern->subject }}</td>
                        <td class="px-5 py-3 text-[#475569]">
                            {{ optional($concern->tenant)->name ?? '—' }}
                            @if ($concern->unit)
                                <div class="text-xs text-[#94a3b8]">{{ optional($concern->unit->property)->name }} / {{ $concern->unit->name }}</div>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $concern->priority === 'high' ? 'bg-[#f5dde1] text-[#7c2233]' : ($concern->priority === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-[#f1f5f9] text-[#475569]') }}">
                                {{ ucfirst($concern->priority) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <x-badge :tone="$concern->status === 'resolved' ? 'positive' : ($concern->status === 'in_progress' ? 'warning' : 'neutral')">
                                {{ ucfirst(str_replace('_', ' ', $concern->status)) }}
                            </x-badge>
                        </td>
                        <td class="px-5 py-3 text-[#475569]">{{ $concern->reported_date?->format('M j, Y') ?? '—' }}</td>
                        <td class="px-5 py-3 text-right space-x-3">
                            <a href="{{ route('concerns.edit', $concern) }}" class="text-[#4f46e5] hover:underline">Edit</a>
                            <form action="{{ route('concerns.destroy', $concern) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this concern?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#9f2d42] hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-6 text-center text-[#64748b]">No concerns logged.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
