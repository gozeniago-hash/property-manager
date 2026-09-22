<x-layout title="Add Unit">
    <form action="{{ route('units.store') }}" method="POST" class="bg-white rounded-xl border border-[#e2e8f0] p-6 max-w-xl space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Property</label>
            <select name="property_id" required class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                <option value="">Select a property</option>
                @foreach ($properties as $property)
                    <option value="{{ $property->id }}" @selected(old('property_id') == $property->id)>{{ $property->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Unit name</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Unit 1, Room A"
                   class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Monthly rent (₱)</label>
            <input type="number" step="0.01" min="0" name="monthly_rent" value="{{ old('monthly_rent') }}"
                   class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Status</label>
            <select name="status" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                <option value="vacant" @selected(old('status', 'vacant') === 'vacant')>Vacant</option>
                <option value="occupied" @selected(old('status') === 'occupied')>Occupied</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Notes</label>
            <textarea name="notes" rows="3"
                      class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">{{ old('notes') }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">Save</button>
            <a href="{{ route('units.index') }}" class="text-sm text-[#475569] px-4 py-2">Cancel</a>
        </div>
    </form>
</x-layout>
