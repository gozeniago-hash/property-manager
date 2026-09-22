<x-layout title="Edit Expense">
    <form action="{{ route('expenses.update', $expense) }}" method="POST" class="bg-white rounded-xl border border-[#e2e8f0] p-6 max-w-xl space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Property (optional)</label>
                <select name="property_id" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                    <option value="">— General / not property-specific —</option>
                    @foreach ($properties as $property)
                        <option value="{{ $property->id }}" @selected(old('property_id', $expense->property_id) == $property->id)>{{ $property->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Category</label>
                <select name="category" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                    @foreach (['maintenance' => 'Maintenance', 'utilities' => 'Utilities', 'supplies' => 'Supplies', 'salaries' => 'Salaries', 'marketing' => 'Marketing', 'taxes' => 'Taxes', 'other' => 'Other'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('category', $expense->category) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Description (optional)</label>
            <input type="text" name="description" value="{{ old('description', $expense->description) }}"
                   class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Amount (₱)</label>
                <input type="number" step="0.01" min="0" name="amount" value="{{ old('amount', $expense->amount) }}" required
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Date</label>
                <input type="date" name="expense_date" value="{{ old('expense_date', optional($expense->expense_date)->toDateString()) }}" required
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Notes</label>
            <textarea name="notes" rows="3"
                      class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">{{ old('notes', $expense->notes) }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">Save changes</button>
            <a href="{{ route('expenses.index') }}" class="text-sm text-[#475569] px-4 py-2">Cancel</a>
        </div>
    </form>
</x-layout>
