<x-layout title="Edit Property">
    <form action="{{ route('properties.update', $property) }}" method="POST" class="bg-white rounded-xl border border-[#e2e8f0] p-6 max-w-xl space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Property name</label>
            <input type="text" name="name" value="{{ old('name', $property->name) }}" required
                   class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Address</label>
            <input type="text" name="address" value="{{ old('address', $property->address) }}"
                   class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Notes</label>
            <textarea name="notes" rows="3"
                      class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">{{ old('notes', $property->notes) }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">Update</button>
            <a href="{{ route('properties.index') }}" class="text-sm text-[#475569] px-4 py-2">Cancel</a>
        </div>
    </form>
</x-layout>
