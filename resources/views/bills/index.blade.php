<x-layout title="Bills & Payments">
    <div class="flex items-center justify-between mb-4">
        <div class="flex gap-2 text-sm">
            <a href="{{ route('bills.index') }}" class="px-3 py-1.5 rounded-full {{ request('status') ? 'bg-white border border-[#e2e8f0] text-[#475569]' : 'bg-[#0f172a] text-white' }}">All</a>
            <a href="{{ route('bills.index', ['status' => 'unpaid']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'unpaid' ? 'bg-[#0f172a] text-white' : 'bg-white border border-[#e2e8f0] text-[#475569]' }}">Unpaid</a>
            <a href="{{ route('bills.index', ['status' => 'partial']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'partial' ? 'bg-[#0f172a] text-white' : 'bg-white border border-[#e2e8f0] text-[#475569]' }}">Partial</a>
            <a href="{{ route('bills.index', ['status' => 'paid']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'paid' ? 'bg-[#0f172a] text-white' : 'bg-white border border-[#e2e8f0] text-[#475569]' }}">Paid</a>
        </div>
        <a href="{{ route('bills.create') }}" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">
            + Add Bill
        </a>
    </div>

    <div class="space-y-3">
        @forelse ($bills as $bill)
            <details class="bg-white rounded-xl border border-[#e2e8f0] group">
                <summary class="cursor-pointer list-none px-5 py-4 flex items-center justify-between">
                    <div>
                        <div class="font-medium text-[#1e293b]">
                            {{ ucfirst($bill->type) }}
                            @if ($bill->description) &middot; {{ $bill->description }} @endif
                        </div>
                        <div class="text-xs text-[#64748b] mt-0.5">
                            {{ optional($bill->unit->property ?? null)->name }} / {{ optional($bill->unit)->name }}
                            &middot; Due {{ $bill->due_date?->format('M j, Y') }}
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <div class="font-semibold text-[#0f172a]">₱{{ number_format($bill->amount, 2) }}</div>
                            <div class="text-xs text-[#64748b]">Balance: ₱{{ number_format($bill->balance(), 2) }}</div>
                        </div>
                        <x-badge :tone="$bill->status === 'paid' ? 'positive' : ($bill->status === 'partial' ? 'warning' : 'negative')">
                            {{ ucfirst($bill->status) }}
                        </x-badge>
                        <a href="{{ route('bills.edit', $bill) }}" class="text-[#4f46e5] hover:underline text-sm">Edit</a>
                    </div>
                </summary>

                <div class="border-t border-[#f1f5f9] px-5 py-4 space-y-4">
                    <div>
                        <div class="text-xs font-semibold text-[#64748b] uppercase mb-2">Payments</div>
                        @forelse ($bill->payments as $payment)
                            <div class="flex items-center justify-between text-sm py-1.5 border-b border-[#f1f5f9] last:border-0">
                                <div>
                                    ₱{{ number_format($payment->amount, 2) }} &middot; {{ $payment->payment_date?->format('M j, Y') }}
                                    &middot; {{ ucfirst(str_replace('_',' ', $payment->method)) }}
                                    @if ($payment->reference_no) &middot; Ref: {{ $payment->reference_no }} @endif
                                </div>
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Remove this payment?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[#9f2d42] hover:underline text-xs">Remove</button>
                                </form>
                            </div>
                        @empty
                            <div class="text-sm text-[#64748b]">No payments recorded yet.</div>
                        @endforelse
                    </div>

                    <form action="{{ route('payments.store', $bill) }}" method="POST" class="grid grid-cols-2 md:grid-cols-5 gap-3 items-end">
                        @csrf
                        <div class="col-span-1">
                            <label class="block text-xs text-[#64748b] mb-1">Amount</label>
                            <input type="number" step="0.01" min="0.01" name="amount" required
                                   class="w-full rounded-lg border border-[#cbd5e1] px-2 py-1.5 text-sm">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs text-[#64748b] mb-1">Date</label>
                            <input type="date" name="payment_date" value="{{ now()->toDateString() }}" required
                                   class="w-full rounded-lg border border-[#cbd5e1] px-2 py-1.5 text-sm">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs text-[#64748b] mb-1">Method</label>
                            <select name="method" class="w-full rounded-lg border border-[#cbd5e1] px-2 py-1.5 text-sm">
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank transfer</option>
                                <option value="gcash">GCash</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs text-[#64748b] mb-1">Tenant</label>
                            <select name="tenant_id" class="w-full rounded-lg border border-[#cbd5e1] px-2 py-1.5 text-sm">
                                <option value="">—</option>
                                @foreach (optional($bill->unit)->tenants ?? [] as $tenant)
                                    <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-1">
                            <button type="submit" class="w-full bg-[#0f172a] hover:bg-[#1e293b] text-white text-sm font-medium rounded-lg px-3 py-1.5">
                                Record payment
                            </button>
                        </div>
                    </form>
                </div>
            </details>
        @empty
            <div class="bg-white rounded-xl border border-[#e2e8f0] px-5 py-6 text-center text-[#64748b]">No bills found.</div>
        @endforelse
    </div>
</x-layout>
