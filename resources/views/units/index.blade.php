<x-layout title="Units">
    <div class="flex justify-end mb-4">
        <a href="{{ route('units.create') }}" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">
            + Add Unit
        </a>
    </div>

    <div class="bg-white rounded-xl border border-[#e2e8f0] overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#f8fafc] text-left text-xs uppercase text-[#64748b]">
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
                        <td class="px-5 py-3 text-[#475569]">{{ optional($unit->property)->name }}</td>
                        <td class="px-5 py-3 font-medium text-[#1e293b]">{{ $unit->name }}</td>
                        <td class="px-5 py-3">
                            <x-badge :tone="$unit->status === 'occupied' ? 'positive' : 'neutral'">
                                {{ ucfirst($unit->status) }}
                            </x-badge>
                        </td>
                        <td class="px-5 py-3">{{ $unit->monthly_rent ? '₱'.number_format($unit->monthly_rent, 2) : '—' }}</td>
                        <td class="px-5 py-3">{{ optional($unit->currentTenant)->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-right space-x-3">
                            <a href="{{ route('units.edit', $unit) }}" class="text-[#4f46e5] hover:underline">Edit</a>
                            <form action="{{ route('units.destroy', $unit) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this unit?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#9f2d42] hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-6 text-center text-[#64748b]">No units yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
