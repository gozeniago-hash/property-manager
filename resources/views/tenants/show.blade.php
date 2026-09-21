<x-layout :title="$tenant->name">
    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 p-4 text-sm">
            <div class="text-xs text-slate-500 uppercase mb-1">Unit</div>
            {{ $tenant->unit ? ($tenant->unit->property->name.' / '.$tenant->unit->name) : 'Unassigned' }}
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 text-sm">
            <div class="text-xs text-slate-500 uppercase mb-1">Contact</div>
            {{ $tenant->phone ?: '—' }}<br>{{ $tenant->email ?: '' }}
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 text-sm">
            <div class="text-xs text-slate-500 uppercase mb-1">Status</div>
            <span class="text-xs px-2 py-0.5 rounded-full {{ $tenant->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                {{ ucfirst($tenant->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-slate-200">
            <div class="px-5 py-4 border-b border-slate-200 font-semibold text-slate-900">Payment History</div>
            <div class="divide-y divide-slate-100">
                @forelse ($tenant->payments as $payment)
                    <div class="px-5 py-3 text-sm flex items-center justify-between">
                        <div>
                            <div class="text-slate-800">{{ optional($payment->bill)->type ? ucfirst($payment->bill->type) : 'Bill' }}</div>
                            <div class="text-xs text-slate-500">{{ $payment->payment_date?->format('M j, Y') }} &middot; {{ ucfirst(str_replace('_',' ', $payment->method)) }}</div>
                        </div>
                        <div class="font-semibold text-green-700">₱{{ number_format($payment->amount, 2) }}</div>
                    </div>
                @empty
                    <div class="px-5 py-6 text-sm text-slate-500">No payments recorded yet.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200">
            <div class="px-5 py-4 border-b border-slate-200 font-semibold text-slate-900">Concerns Raised</div>
            <div class="divide-y divide-slate-100">
                @forelse ($tenant->concerns as $concern)
                    <div class="px-5 py-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-800">{{ $concern->subject }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $concern->status === 'resolved' ? 'bg-green-100 text-green-700' : ($concern->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                {{ ucfirst(str_replace('_',' ', $concern->status)) }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-500">{{ $concern->reported_date?->format('M j, Y') }}</div>
                    </div>
                @empty
                    <div class="px-5 py-6 text-sm text-slate-500">No concerns raised.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('tenants.index') }}" class="text-sm text-slate-600 hover:underline">&larr; Back to tenants</a>
    </div>
</x-layout>
