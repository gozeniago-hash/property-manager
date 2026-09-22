<x-layout title="Log Tenant Concern">
    <form action="{{ route('concerns.store') }}" method="POST" class="bg-white rounded-xl border border-[#e2e8f0] p-6 max-w-xl space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Subject</label>
            <input type="text" name="subject" value="{{ old('subject') }}" required
                   class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Tenant</label>
                <select name="tenant_id" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                    <option value="">—</option>
                    @foreach ($tenants as $tenant)
                        <option value="{{ $tenant->id }}" @selected(old('tenant_id') == $tenant->id)>{{ $tenant->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Unit</label>
                <select name="unit_id" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                    <option value="">—</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
                            {{ optional($unit->property)->name }} / {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Description</label>
            <textarea name="description" rows="4"
                      class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">{{ old('description') }}</textarea>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Priority</label>
                <select name="priority" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                    <option value="low" @selected(old('priority') === 'low')>Low</option>
                    <option value="medium" @selected(old('priority', 'medium') === 'medium')>Medium</option>
                    <option value="high" @selected(old('priority') === 'high')>High</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Status</label>
                <select name="status" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                    <option value="open" @selected(old('status', 'open') === 'open')>Open</option>
                    <option value="in_progress" @selected(old('status') === 'in_progress')>In progress</option>
                    <option value="resolved" @selected(old('status') === 'resolved')>Resolved</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Reported date</label>
                <input type="date" name="reported_date" value="{{ old('reported_date', now()->toDateString()) }}"
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">Save</button>
            <a href="{{ route('concerns.index') }}" class="text-sm text-[#475569] px-4 py-2">Cancel</a>
        </div>
    </form>
</x-layout>
