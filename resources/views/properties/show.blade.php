<x-layout :title="$property->name">
    <div class="mb-4 text-sm text-[#475569]">{{ $property->address }}</div>

    @if ($property->notes)
        <div class="mb-6 bg-white rounded-xl border border-[#e2e8f0] p-4 text-sm text-[#475569]">
            {{ $property->notes }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-3">
        <h2 class="font-semibold text-[#0f172a]">Units</h2>
        <a href="{{ route('units.create') }}" class="text-sm text-[#4f46e5] hover:underline">+ Add unit</a>
    </div>

    <div class="bg-white rounded-xl border border-[#e2e8f0] overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#f8fafc] text-left text-xs uppercase text-[#64748b]">
                <tr>
                    <th class="px-5 py-3">Unit</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Monthly Rent</th>
                    <th class="px-5 py-3">Current Tenant</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($property->units as $unit)
                    <tr>
                        <td class="px-5 py-3 font-medium text-[#1e293b]">{{ $unit->name }}</td>
                        <td class="px-5 py-3">
                            <x-badge :tone="$unit->status === 'occupied' ? 'positive' : 'neutral'">
                                {{ ucfirst($unit->status) }}
                            </x-badge>
                        </td>
                        <td class="px-5 py-3">{{ $unit->monthly_rent ? '₱'.number_format($unit->monthly_rent, 2) : '—' }}</td>
                        <td class="px-5 py-3">{{ optional($unit->currentTenant)->name ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-6 text-center text-[#64748b]">No units yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('properties.index') }}" class="text-sm text-[#475569] hover:underline">&larr; Back to properties</a>
    </div>
</x-layout>
