<x-layout title="Tenant Concerns">
    <div class="flex items-center justify-between mb-4">
        <div class="flex gap-2 text-sm">
            <a href="{{ route('concerns.index') }}" class="px-3 py-1.5 rounded-full {{ request('status') ? 'bg-white border border-slate-200 text-slate-600' : 'bg-slate-900 text-white' }}">All</a>
            <a href="{{ route('concerns.index', ['status' => 'open']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'open' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">Open</a>
            <a href="{{ route('concerns.index', ['status' => 'in_progress']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'in_progress' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">In progress</a>
            <a href="{{ route('concerns.index', ['status' => 'resolved']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'resolved' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">Resolved</a>
        </div>
        <a href="{{ route('concerns.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
            + Log Concern
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
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
                        <td class="px-5 py-3 font-medium text-slate-800">{{ $concern->subject }}</td>
                        <td class="px-5 py-3 text-slate-600">
                            {{ optional($concern->tenant)->name ?? '—' }}
                            @if ($concern->unit)
                                <div class="text-xs text-slate-400">{{ optional($concern->unit->property)->name }} / {{ $concern->unit->name }}</div>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $concern->priority === 'high' ? 'bg-red-100 text-red-700' : ($concern->priority === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                {{ ucfirst($concern->priority) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $concern->status === 'resolved' ? 'bg-green-100 text-green-700' : ($concern->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                {{ ucfirst(str_replace('_',' ', $concern->status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $concern->reported_date?->format('M j, Y') ?? '—' }}</td>
                        <td class="px-5 py-3 text-right space-x-3">
                            <a href="{{ route('concerns.edit', $concern) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('concerns.destroy', $concern) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this concern?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-6 text-center text-slate-500">No concerns logged.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
