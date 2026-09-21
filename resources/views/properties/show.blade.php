<x-layout :title="$property->name">
    <div class="mb-4 text-sm text-slate-600">{{ $property->address }}</div>

    @if ($property->notes)
        <div class="mb-6 bg-white rounded-xl border border-slate-200 p-4 text-sm text-slate-600">
            {{ $property->notes }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-3">
        <h2 class="font-semibold text-slate-900">Units</h2>
        <a href="{{ route('units.create') }}" class="text-sm text-blue-600 hover:underline">+ Add unit</a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
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
                        <td class="px-5 py-3 font-medium text-slate-800">{{ $unit->name }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $unit->status === 'occupied' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($unit->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3">{{ $unit->monthly_rent ? '₱'.number_format($unit->monthly_rent, 2) : '—' }}</td>
                        <td class="px-5 py-3">{{ optional($unit->currentTenant)->name ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-6 text-center text-slate-500">No units yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('properties.index') }}" class="text-sm text-slate-600 hover:underline">&larr; Back to properties</a>
    </div>
</x-layout>
