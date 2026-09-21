<x-layout title="Properties">
    <div class="flex justify-end mb-4">
        <a href="{{ route('properties.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
            + Add Property
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Address</th>
                    <th class="px-5 py-3">Units</th>
                    <th class="px-5 py-3">Occupied</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($properties as $property)
                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-800">
                            <a href="{{ route('properties.show', $property) }}" class="hover:underline">{{ $property->name }}</a>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $property->address ?: '—' }}</td>
                        <td class="px-5 py-3">{{ $property->units_count }}</td>
                        <td class="px-5 py-3">{{ $property->units->count() }}</td>
                        <td class="px-5 py-3 text-right space-x-3">
                            <a href="{{ route('properties.edit', $property) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('properties.destroy', $property) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this property and all its units?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-6 text-center text-slate-500">No properties yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
