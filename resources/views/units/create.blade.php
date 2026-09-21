<x-layout title="Add Unit">
    <form action="{{ route('units.store') }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-6 max-w-xl space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Property</label>
            <select name="property_id" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select a property</option>
                @foreach ($properties as $property)
                    <option value="{{ $property->id }}" @selected(old('property_id') == $property->id)>{{ $property->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Unit name</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Unit 1, Room A"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Monthly rent (₱)</label>
            <input type="number" step="0.01" min="0" name="monthly_rent" value="{{ old('monthly_rent') }}"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="vacant" @selected(old('status', 'vacant') === 'vacant')>Vacant</option>
                <option value="occupied" @selected(old('status') === 'occupied')>Occupied</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Notes</label>
            <textarea name="notes" rows="3"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">Save</button>
            <a href="{{ route('units.index') }}" class="text-sm text-slate-600 px-4 py-2">Cancel</a>
        </div>
    </form>
</x-layout>
