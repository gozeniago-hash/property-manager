<x-layout title="Edit Property">
    <form action="{{ route('properties.update', $property) }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-6 max-w-xl space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Property name</label>
            <input type="text" name="name" value="{{ old('name', $property->name) }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Address</label>
            <input type="text" name="address" value="{{ old('address', $property->address) }}"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Notes</label>
            <textarea name="notes" rows="3"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $property->notes) }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">Update</button>
            <a href="{{ route('properties.index') }}" class="text-sm text-slate-600 px-4 py-2">Cancel</a>
        </div>
    </form>
</x-layout>
