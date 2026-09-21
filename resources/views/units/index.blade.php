<x-layout title="Units">
    <div class="flex justify-end mb-4">
        <a href="{{ route('units.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
            + Add Unit
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-5 py-3">Property</th>
                    <th class="px-5 py-3">Unit</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Monthly Rent</th>
                    <th class="px-5 py-3">Tenant</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($units as $unit)
                    <tr>
                        <td class="px-5 py-3 text-slate-600">{{ optional($unit->property)->name }}</td>
                        <td class="px-5 py-3 font-medium text-slate-800">{{ $unit->name }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $unit->status === 'occupied' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($unit->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">{{ $unit->monthly_rent ? '₱'.number_format($unit->monthly_rent, 2) : '—' }}</td>
                        <td class="px-5 py-3">{{ optional($unit->currentTenant)->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-right space-x-3">
                            <a href="{{ route('units.edit', $unit) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('units.destroy', $unit) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this unit?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-6 text-center text-slate-500">No units yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
