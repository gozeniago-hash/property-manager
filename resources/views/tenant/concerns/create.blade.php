<x-tenant-layout title="Raise a Concern">
    <form action="{{ route('tenant.concerns.store') }}" method="POST" class="bg-white rounded-xl border border-[#e2e8f0] p-6 max-w-xl space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Subject</label>
            <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="e.g. Leaking faucet in kitchen"
                   class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Description</label>
            <textarea name="description" rows="4" placeholder="Give as much detail as you can."
                      class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">{{ old('description') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Priority</label>
            <select name="priority" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                <option value="low" @selected(old('priority') === 'low')>Low</option>
                <option value="medium" @selected(old('priority', 'medium') === 'medium')>Medium</option>
                <option value="high" @selected(old('priority') === 'high')>High</option>
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">Submit</button>
            <a href="{{ route('tenant.concerns.index') }}" class="text-sm text-[#475569] px-4 py-2">Cancel</a>
        </div>
    </form>
</x-tenant-layout>
