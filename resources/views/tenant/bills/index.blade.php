<x-tenant-layout title="My Bills">
    @if (! $tenant->unit_id)
        <div class="bg-white rounded-xl border border-slate-200 px-5 py-6 text-center text-slate-500">
            You're not currently assigned to a unit, so there are no bills to show.
        </div>
    @else
        <div class="space-y-3">
            @forelse ($bills as $bill)
                <div class="bg-white rounded-xl border border-slate-200 px-5 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-medium text-slate-800">
                                {{ ucfirst($bill->type) }}
                                @if ($bill->description) &middot; {{ $bill->description }} @endif
                            </div>
                            <div class="text-xs text-slate-500 mt-0.5">Due {{ $bill->due_date?->format('M j, Y') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-slate-900">₱{{ number_format($bill->amount, 2) }}</div>
                            <div class="text-xs text-slate-500">Balance: ₱{{ number_format($bill->balance(), 2) }}</div>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $bill->status === 'paid' ? 'bg-green-100 text-green-700' : ($bill->status === 'partial' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($bill->status) }}
                        </span>
                    </div>

                    @if ($bill->payments->isNotEmpty())
                        <div class="mt-3 pt-3 border-t border-slate-100 space-y-1">
                            @foreach ($bill->payments as $payment)
                                <div class="text-xs text-slate-500 flex justify-between">
                                    <span>{{ $payment->payment_date?->format('M j, Y') }} &middot; {{ ucfirst(str_replace('_', ' ', $payment->method)) }}</span>
                                    <span class="text-green-700 font-medium">₱{{ number_format($payment->amount, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-xl border border-slate-200 px-5 py-6 text-center text-slate-500">No bills yet.</div>
            @endforelse
        </div>
    @endif
</x-tenant-layout>
