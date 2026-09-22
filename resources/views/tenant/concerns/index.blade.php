<x-tenant-layout title="My Concerns">
    <div class="flex justify-end mb-4">
        <a href="{{ route('tenant.concerns.create') }}" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">
            + Raise a Concern
        </a>
    </div>

    <div class="bg-white rounded-xl border border-[#e2e8f0] overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#f8fafc] text-left text-xs uppercase text-[#64748b]">
                <tr>
                    <th class="px-5 py-3">Subject</th>
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
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('tenant.concerns.show', $concern) }}" class="text-[#4f46e5] hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-6 text-center text-[#64748b]">You haven't raised any concerns yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-tenant-layout>
