<x-tenant-layout title="My Concerns">
    <div class="flex justify-end mb-4">
        <a href="{{ route('tenant.concerns.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
            + Raise a Concern
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
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
                        <td class="px-5 py-3 font-medium text-slate-800">{{ $concern->subject }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $concern->priority === 'high' ? 'bg-red-100 text-red-700' : ($concern->priority === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                {{ ucfirst($concern->priority) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $concern->status === 'resolved' ? 'bg-green-100 text-green-700' : ($concern->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                {{ ucfirst(str_replace('_', ' ', $concern->status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $concern->reported_date?->format('M j, Y') ?? '—' }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('tenant.concerns.show', $concern) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-6 text-center text-slate-500">You haven't raised any concerns yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-tenant-layout>
