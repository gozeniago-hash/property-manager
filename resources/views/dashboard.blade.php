<x-layout title="Dashboard">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="text-xs text-slate-500 uppercase tracking-wide">Properties</div>
            <div class="text-2xl font-semibold text-slate-900 mt-1">{{ $totalProperties }}</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="text-xs text-slate-500 uppercase tracking-wide">Units (occupied)</div>
            <div class="text-2xl font-semibold text-slate-900 mt-1">{{ $totalUnits }} <span class="text-sm text-slate-500 font-normal">({{ $occupiedUnits }} occ.)</span></div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="text-xs text-slate-500 uppercase tracking-wide">Active Tenants</div>
            <div class="text-2xl font-semibold text-slate-900 mt-1">{{ $activeTenants }}</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="text-xs text-slate-500 uppercase tracking-wide">Unpaid Bills</div>
            <div class="text-2xl font-semibold text-red-600 mt-1">₱{{ number_format($unpaidTotal, 2) }}</div>
            <div class="text-xs text-slate-500">{{ $unpaidCount }} bill(s), {{ $overdueBills->count() }} overdue</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-slate-200">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <h2 class="font-semibold text-slate-900">Open Tenant Concerns</h2>
                <a href="{{ route('concerns.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($openConcerns->take(6) as $concern)
                    <div class="px-5 py-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-slate-800">{{ $concern->subject }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $concern->priority === 'high' ? 'bg-red-100 text-red-700' : ($concern->priority === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                {{ ucfirst($concern->priority) }}
                            </span>
                        </div>
                        <div class="text-slate-500 text-xs mt-0.5">
                            {{ optional($concern->tenant)->name ?? 'Unassigned tenant' }}
                            @if ($concern->unit) &middot; {{ $concern->unit->property->name ?? '' }} / {{ $concern->unit->name }} @endif
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-6 text-sm text-slate-500">No open concerns. 🎉</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <h2 class="font-semibold text-slate-900">Recent Payments</h2>
                <a href="{{ route('bills.index') }}" class="text-sm text-blue-600 hover:underline">View bills</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($recentPayments as $payment)
                    <div class="px-5 py-3 text-sm flex items-center justify-between">
                        <div>
                            <div class="font-medium text-slate-800">{{ optional($payment->tenant)->name ?? 'Tenant' }}</div>
                            <div class="text-xs text-slate-500">
                                {{ optional($payment->bill)->type ? ucfirst($payment->bill->type) : 'Bill' }}
                                &middot; {{ $payment->payment_date?->format('M j, Y') }}
                            </div>
                        </div>
                        <div class="font-semibold text-green-700">₱{{ number_format($payment->amount, 2) }}</div>
                    </div>
                @empty
                    <div class="px-5 py-6 text-sm text-slate-500">No payments recorded yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>
