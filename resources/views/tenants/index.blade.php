<x-layout title="Tenants">
    <div class="flex justify-end mb-4">
        <a href="{{ route('tenants.create') }}" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">
            + Add Tenant
        </a>
    </div>

    <div class="bg-white rounded-xl border border-[#e2e8f0] overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#f8fafc] text-left text-xs uppercase text-[#64748b]">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Unit</th>
                    <th class="px-5 py-3">Contact</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($tenants as $tenant)
                    <tr>
                        <td class="px-5 py-3 font-medium text-[#1e293b]">
                            <a href="{{ route('tenants.show', $tenant) }}" class="hover:underline">{{ $tenant->name }}</a>
                        </td>
                        <td class="px-5 py-3 text-[#475569]">
                            @if ($tenant->unit)
                                {{ $tenant->unit->property->name ?? '' }} / {{ $tenant->unit->name }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-5 py-3 text-[#475569]">
                            {{ $tenant->phone ?: '' }} {{ $tenant->phone && $tenant->email ? '·' : '' }} {{ $tenant->email ?: '' }}
                            @if (!$tenant->phone && !$tenant->email) — @endif
                        </td>
                        <td class="px-5 py-3">
                            <x-badge :tone="$tenant->status === 'active' ? 'positive' : 'neutral'">
                                {{ ucfirst($tenant->status) }}
                            </x-badge>
                        </td>
                        <td class="px-5 py-3 text-right space-x-3">
                            <a href="{{ route('tenants.edit', $tenant) }}" class="text-[#4f46e5] hover:underline">Edit</a>
                            <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this tenant?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#9f2d42] hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-6 text-center text-[#64748b]">No tenants yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
