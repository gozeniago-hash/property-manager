<x-layout title="Bills & Payments">
    <div class="flex items-center justify-between mb-4">
        <div class="flex gap-2 text-sm">
            <a href="{{ route('bills.index') }}" class="px-3 py-1.5 rounded-full {{ request('status') ? 'bg-white border border-slate-200 text-slate-600' : 'bg-slate-900 text-white' }}">All</a>
            <a href="{{ route('bills.index', ['status' => 'unpaid']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'unpaid' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">Unpaid</a>
            <a href="{{ route('bills.index', ['status' => 'partial']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'partial' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">Partial</a>
            <a href="{{ route('bills.index', ['status' => 'paid']) }}" class="px-3 py-1.5 rounded-full {{ request('status') === 'paid' ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">Paid</a>
        </div>
        <a href="{{ route('bills.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
            + Add Bill
        </a>
    </div>

    <div class="space-y-3">
        @forelse ($bills as $bill)
            <details class="bg-white rounded-xl border border-slate-200 group">
                <summary class="cursor-pointer list-none px-5 py-4 flex items-center justify-between">
                    <div>
                        <div class="font-medium text-slate-800">
                            {{ ucfirst($bill->type) }}
                            @if ($bill->description) &middot; {{ $bill->description }} @endif
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5">
                            {{ optional($bill->unit->property ?? null)->name }} / {{ optional($bill->unit)->name }}
                            &middot; Due {{ $bill->due_date?->format('M j, Y') }}
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <div class="font-semibold text-slate-900">₱{{ number_format($bill->amount, 2) }}</div>
                            <div class="text-xs text-slate-500">Balance: ₱{{ number_format($bill->balance(), 2) }}</div>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $bill->status === 'paid' ? 'bg-green-100 text-green-700' : ($bill->status === 'partial' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($bill->status) }}
                        </span>
                        <a href="{{ route('bills.edit', $bill) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                    </div>
                </summary>

                <div class="border-t border-slate-100 px-5 py-4 space-y-4">
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase mb-2">Payments</div>
                        @forelse ($bill->payments as $payment)
                            <div class="flex items-center justify-between text-sm py-1.5 border-b border-slate-50 last:border-0">
                                <div>
                                    ₱{{ number_format($payment->amount, 2) }} &middot; {{ $payment->payment_date?->format('M j, Y') }}
                                    &middot; {{ ucfirst(str_replace('_',' ', $payment->method)) }}
                                    @if ($payment->reference_no) &middot; Ref: {{ $payment->reference_no }} @endif
                                </div>
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Remove this payment?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs">Remove</button>
                                </form>
                            </div>
                        @empty
                            <div class="text-sm text-slate-500">No payments recorded yet.</div>
                        @endforelse
                    </div>

                    <form action="{{ route('payments.store', $bill) }}" method="POST" class="grid grid-cols-2 md:grid-cols-5 gap-3 items-end">
                        @csrf
                        <div class="col-span-1">
                            <label class="block text-xs text-slate-500 mb-1">Amount</label>
                            <input type="number" step="0.01" min="0.01" name="amount" required
                                   class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-sm">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs text-slate-500 mb-1">Date</label>
                            <input type="date" name="payment_date" value="{{ now()->toDateString() }}" required
                                   class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-sm">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs text-slate-500 mb-1">Method</label>
                            <select name="method" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-sm">
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank transfer</option>
                                <option value="gcash">GCash</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs text-slate-500 mb-1">Tenant</label>
                            <select name="tenant_id" class="w-full rounded-lg border border-slate-300 px-2 py-1.5 text-sm">
                                <option value="">—</option>
                                @foreach (optional($bill->unit)->tenants ?? [] as $tenant)
                                    <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-1">
                            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-lg px-3 py-1.5">
                                Record payment
                            </button>
                        </div>
                    </form>
                </div>
            </details>
        @empty
            <div class="bg-white rounded-xl border border-slate-200 px-5 py-6 text-center text-slate-500">No bills found.</div>
        @endforelse
    </div>
</x-layout>
