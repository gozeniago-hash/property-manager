<x-tenant-layout title="Raise a Concern">
    <form action="{{ route('tenant.concerns.store') }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-6 max-w-xl space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Subject</label>
            <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="e.g. Leaking faucet in kitchen"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
            <textarea name="description" rows="4" placeholder="Give as much detail as you can."
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Priority</label>
            <select name="priority" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="low" @selected(old('priority') === 'low')>Low</option>
                <option value="medium" @selected(old('priority', 'medium') === 'medium')>Medium</option>
                <option value="high" @selected(old('priority') === 'high')>High</option>
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">Submit</button>
            <a href="{{ route('tenant.concerns.index') }}" class="text-sm text-slate-600 px-4 py-2">Cancel</a>
        </div>
    </form>
</x-tenant-layout>
