<x-layout title="Dashboard">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Properties</div>
            <div class="text-2xl font-semibold text-[#0f172a] mt-1">{{ $totalProperties }}</div>
        </div>
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Units (occupied)</div>
            <div class="text-2xl font-semibold text-[#0f172a] mt-1">{{ $totalUnits }} <span class="text-sm text-[#64748b] font-normal">({{ $occupiedUnits }} occ.)</span></div>
        </div>
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Active Tenants</div>
            <div class="text-2xl font-semibold text-[#0f172a] mt-1">{{ $activeTenants }}</div>
        </div>
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Unpaid Bills</div>
            <div class="text-2xl font-semibold text-[#9f2d42] mt-1">₱{{ number_format($unpaidTotal, 2) }}</div>
            <div class="text-xs text-[#64748b]">{{ $unpaidCount }} bill(s), {{ $overdueBills->count() }} overdue</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-[#e2e8f0]">
            <div class="px-5 py-4 border-b border-[#e2e8f0] flex items-center justify-between">
                <h2 class="font-semibold text-[#0f172a]">Open Tenant Concerns</h2>
                <a href="{{ route('concerns.index') }}" class="text-sm text-[#4f46e5] hover:underline">View all</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($openConcerns->take(6) as $concern)
                    <div class="px-5 py-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-[#1e293b]">{{ $concern->subject }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $concern->priority === 'high' ? 'bg-[#f5dde1] text-[#7c2233]' : ($concern->priority === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-[#f1f5f9] text-[#475569]') }}">
                                {{ ucfirst($concern->priority) }}
                            </span>
                        </div>
                        <div class="text-[#64748b] text-xs mt-0.5">
                            {{ optional($concern->tenant)->name ?? 'Unassigned tenant' }}
                            @if ($concern->unit) &middot; {{ $concern->unit->property->name ?? '' }} / {{ $concern->unit->name }} @endif
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-6 text-sm text-[#64748b]">No open concerns. 🎉</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-[#e2e8f0]">
            <div class="px-5 py-4 border-b border-[#e2e8f0] flex items-center justify-between">
                <h2 class="font-semibold text-[#0f172a]">Recent Payments</h2>
                <a href="{{ route('bills.index') }}" class="text-sm text-[#4f46e5] hover:underline">View bills</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($recentPayments as $payment)
                    <div class="px-5 py-3 text-sm flex items-center justify-between">
                        <div>
                            <div class="font-medium text-[#1e293b]">{{ optional($payment->tenant)->name ?? 'Tenant' }}</div>
                            <div class="text-xs text-[#64748b]">
                                {{ optional($payment->bill)->type ? ucfirst($payment->bill->type) : 'Bill' }}
                                &middot; {{ $payment->payment_date?->format('M j, Y') }}
                            </div>
                        </div>
                        <div class="font-semibold text-[#1e293b]">₱{{ number_format($payment->amount, 2) }}</div>
                    </div>
                @empty
                    <div class="px-5 py-6 text-sm text-[#64748b]">No payments recorded yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>
