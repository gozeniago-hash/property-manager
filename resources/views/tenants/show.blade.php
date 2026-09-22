<x-layout :title="$tenant->name">
    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4 text-sm">
            <div class="text-xs text-[#64748b] uppercase mb-1">Unit</div>
            {{ $tenant->unit ? ($tenant->unit->property->name.' / '.$tenant->unit->name) : 'Unassigned' }}
        </div>
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4 text-sm">
            <div class="text-xs text-[#64748b] uppercase mb-1">Contact</div>
            {{ $tenant->phone ?: '—' }}<br>{{ $tenant->email ?: '' }}
        </div>
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4 text-sm">
            <div class="text-xs text-[#64748b] uppercase mb-1">Status</div>
            <x-badge :tone="$tenant->status === 'active' ? 'positive' : 'neutral'">
                                {{ ucfirst($tenant->status) }}
                            </x-badge>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-[#e2e8f0]">
            <div class="px-5 py-4 border-b border-[#e2e8f0] font-semibold text-[#0f172a]">Payment History</div>
            <div class="divide-y divide-slate-100">
                @forelse ($tenant->payments as $payment)
                    <div class="px-5 py-3 text-sm flex items-center justify-between">
                        <div>
                            <div class="text-[#1e293b]">{{ optional($payment->bill)->type ? ucfirst($payment->bill->type) : 'Bill' }}</div>
                            <div class="text-xs text-[#64748b]">{{ $payment->payment_date?->format('M j, Y') }} &middot; {{ ucfirst(str_replace('_',' ', $payment->method)) }}</div>
                        </div>
                        <div class="font-semibold text-[#1e293b]">₱{{ number_format($payment->amount, 2) }}</div>
                    </div>
                @empty
                    <div class="px-5 py-6 text-sm text-[#64748b]">No payments recorded yet.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-[#e2e8f0]">
            <div class="px-5 py-4 border-b border-[#e2e8f0] font-semibold text-[#0f172a]">Concerns Raised</div>
            <div class="divide-y divide-slate-100">
                @forelse ($tenant->concerns as $concern)
                    <div class="px-5 py-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-[#1e293b]">{{ $concern->subject }}</span>
                            <x-badge :tone="$concern->status === 'resolved' ? 'positive' : ($concern->status === 'in_progress' ? 'warning' : 'neutral')">
                                {{ ucfirst(str_replace('_', ' ', $concern->status)) }}
                            </x-badge>
                        </div>
                        <div class="text-xs text-[#64748b]">{{ $concern->reported_date?->format('M j, Y') }}</div>
                    </div>
                @empty
                    <div class="px-5 py-6 text-sm text-[#64748b]">No concerns raised.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('tenants.index') }}" class="text-sm text-[#475569] hover:underline">&larr; Back to tenants</a>
    </div>
</x-layout>
