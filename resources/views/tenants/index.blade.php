<x-layout title="Tenants">
    <div class="flex justify-end mb-4">
        <a href="{{ route('tenants.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
            + Add Tenant
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
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
                        <td class="px-5 py-3 font-medium text-slate-800">
                            <a href="{{ route('tenants.show', $tenant) }}" class="hover:underline">{{ $tenant->name }}</a>
                        </td>
                        <td class="px-5 py-3 text-slate-600">
                            @if ($tenant->unit)
                                {{ $tenant->unit->property->name ?? '' }} / {{ $tenant->unit->name }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-5 py-3 text-slate-600">
                            {{ $tenant->phone ?: '' }} {{ $tenant->phone && $tenant->email ? '·' : '' }} {{ $tenant->email ?: '' }}
                            @if (!$tenant->phone && !$tenant->email) — @endif
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $tenant->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($tenant->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right space-x-3">
                            <a href="{{ route('tenants.edit', $tenant) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this tenant?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-6 text-center text-slate-500">No tenants yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
