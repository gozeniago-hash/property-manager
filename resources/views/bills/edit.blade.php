<x-layout title="Edit Bill">
    <form action="{{ route('bills.update', $bill) }}" method="POST" class="bg-white rounded-xl border border-[#e2e8f0] p-6 max-w-xl space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Unit</label>
            <select name="unit_id" required class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" @selected(old('unit_id', $bill->unit_id) == $unit->id)>
                        {{ optional($unit->property)->name }} / {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Bill type</label>
                <select name="type" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                    @foreach (['rent' => 'Rent', 'electricity' => 'Electricity', 'water' => 'Water', 'internet' => 'Internet', 'other' => 'Other'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', $bill->type) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Amount (₱)</label>
                <input type="number" step="0.01" min="0" name="amount" value="{{ old('amount', $bill->amount) }}" required
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Description (optional)</label>
            <input type="text" name="description" value="{{ old('description', $bill->description) }}"
                   class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Billing period</label>
                <input type="date" name="billing_period" value="{{ old('billing_period', optional($bill->billing_period)->toDateString()) }}"
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Due date</label>
                <input type="date" name="due_date" value="{{ old('due_date', optional($bill->due_date)->toDateString()) }}" required
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Status</label>
            <select name="status" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                <option value="unpaid" @selected(old('status', $bill->status) === 'unpaid')>Unpaid</option>
                <option value="partial" @selected(old('status', $bill->status) === 'partial')>Partial</option>
                <option value="paid" @selected(old('status', $bill->status) === 'paid')>Paid</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Notes</label>
            <textarea name="notes" rows="3"
                      class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">{{ old('notes', $bill->notes) }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">Update</button>
            <a href="{{ route('bills.index') }}" class="text-sm text-[#475569] px-4 py-2">Cancel</a>
        </div>
    </form>
</x-layout>
