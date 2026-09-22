<x-layout title="Expenses">
    <form method="GET" class="flex flex-wrap items-end gap-3 mb-4 bg-white rounded-xl border border-[#e2e8f0] p-4">
        <div>
            <label class="block text-xs text-[#64748b] mb-1">Property</label>
            <select name="property_id" class="rounded-lg border border-[#cbd5e1] px-3 py-1.5 text-sm">
                <option value="">All properties</option>
                @foreach ($properties as $property)
                    <option value="{{ $property->id }}" @selected(request('property_id') == $property->id)>{{ $property->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-[#64748b] mb-1">Category</label>
            <select name="category" class="rounded-lg border border-[#cbd5e1] px-3 py-1.5 text-sm">
                <option value="">All categories</option>
                @foreach (['maintenance' => 'Maintenance', 'utilities' => 'Utilities', 'supplies' => 'Supplies', 'salaries' => 'Salaries', 'marketing' => 'Marketing', 'taxes' => 'Taxes', 'other' => 'Other'] as $value => $label)
                    <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-[#64748b] mb-1">From</label>
            <input type="date" name="from" value="{{ request('from') }}" class="rounded-lg border border-[#cbd5e1] px-3 py-1.5 text-sm">
        </div>
        <div>
            <label class="block text-xs text-[#64748b] mb-1">To</label>
            <input type="date" name="to" value="{{ request('to') }}" class="rounded-lg border border-[#cbd5e1] px-3 py-1.5 text-sm">
        </div>
        <button type="submit" class="bg-[#0f172a] hover:bg-[#1e293b] text-white text-sm font-medium rounded-lg px-4 py-2">Filter</button>
        @if (request()->anyFilled(['property_id', 'category', 'from', 'to']))
            <a href="{{ route('expenses.index') }}" class="text-sm text-[#475569] px-2 py-2">Clear</a>
        @endif
        <div class="ml-auto text-right">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Total</div>
            <div class="text-lg font-semibold text-[#0f172a]">₱{{ number_format($totalAmount, 2) }}</div>
        </div>
    </form>

    <div class="flex justify-end mb-4">
        <a href="{{ route('expenses.create') }}" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">
            + Add Expense
        </a>
    </div>

    <div class="bg-white rounded-xl border border-[#e2e8f0] overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#f8fafc] text-left text-xs uppercase text-[#64748b]">
                <tr>
                    <th class="px-5 py-3">Date</th>
                    <th class="px-5 py-3">Category</th>
                    <th class="px-5 py-3">Property</th>
                    <th class="px-5 py-3">Description</th>
                    <th class="px-5 py-3">Amount</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($expenses as $expense)
                    <tr>
                        <td class="px-5 py-3 text-[#475569]">{{ $expense->expense_date?->format('M j, Y') }}</td>
                        <td class="px-5 py-3">
                            <x-badge tone="neutral">{{ ucfirst($expense->category) }}</x-badge>
                        </td>
                        <td class="px-5 py-3 text-[#475569]">{{ optional($expense->property)->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-[#475569]">{{ $expense->description ?: '—' }}</td>
                        <td class="px-5 py-3 font-semibold text-[#0f172a]">₱{{ number_format($expense->amount, 2) }}</td>
                        <td class="px-5 py-3 text-right space-x-3">
                            <a href="{{ route('expenses.edit', $expense) }}" class="text-[#4f46e5] hover:underline">Edit</a>
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this expense?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#9f2d42] hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-6 text-center text-[#64748b]">No expenses recorded yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
