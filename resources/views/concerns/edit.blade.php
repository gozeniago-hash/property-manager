<x-layout title="Edit Concern">
    <form action="{{ route('concerns.update', $concern) }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-6 max-w-xl space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Subject</label>
            <input type="text" name="subject" value="{{ old('subject', $concern->subject) }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tenant</label>
                <select name="tenant_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">—</option>
                    @foreach ($tenants as $tenant)
                        <option value="{{ $tenant->id }}" @selected(old('tenant_id', $concern->tenant_id) == $tenant->id)>{{ $tenant->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Unit</label>
                <select name="unit_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">—</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @selected(old('unit_id', $concern->unit_id) == $unit->id)>
                            {{ optional($unit->property)->name }} / {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
            <textarea name="description" rows="4"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $concern->description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Resolution <span class="text-slate-400 font-normal">(visible to the tenant)</span></label>
            <textarea name="resolution" rows="4" placeholder="e.g. Plumber visited on Sep 22 and replaced the washer. Issue fixed."
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('resolution', $concern->resolution) }}</textarea>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Priority</label>
                <select name="priority" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="low" @selected(old('priority', $concern->priority) === 'low')>Low</option>
                    <option value="medium" @selected(old('priority', $concern->priority) === 'medium')>Medium</option>
                    <option value="high" @selected(old('priority', $concern->priority) === 'high')>High</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="open" @selected(old('status', $concern->status) === 'open')>Open</option>
                    <option value="in_progress" @selected(old('status', $concern->status) === 'in_progress')>In progress</option>
                    <option value="resolved" @selected(old('status', $concern->status) === 'resolved')>Resolved</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Reported date</label>
                <input type="date" name="reported_date" value="{{ old('reported_date', optional($concern->reported_date)->toDateString()) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        @if ($concern->status === 'resolved' || old('status') === 'resolved')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Resolved date</label>
                <input type="date" name="resolved_date" value="{{ old('resolved_date', optional($concern->resolved_date)->toDateString()) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        @endif
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">Update</button>
            <a href="{{ route('concerns.index') }}" class="text-sm text-slate-600 px-4 py-2">Cancel</a>
        </div>
    </form>
</x-layout>
