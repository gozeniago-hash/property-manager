<x-tenant-layout title="My Bills">
    @if (! $tenant->unit_id)
        <div class="bg-white rounded-xl border border-[#e2e8f0] px-5 py-6 text-center text-[#64748b]">
            You're not currently assigned to a unit, so there are no bills to show.
        </div>
    @else
        <div class="space-y-3">
            @forelse ($bills as $bill)
                <div class="bg-white rounded-xl border border-[#e2e8f0] px-5 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-medium text-[#1e293b]">
                                {{ ucfirst($bill->type) }}
                                @if ($bill->description) &middot; {{ $bill->description }} @endif
                            </div>
                            <div class="text-xs text-[#64748b] mt-0.5">Due {{ $bill->due_date?->format('M j, Y') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-[#0f172a]">₱{{ number_format($bill->amount, 2) }}</div>
                            <div class="text-xs text-[#64748b]">Balance: ₱{{ number_format($bill->balance(), 2) }}</div>
                        </div>
                        <x-badge :tone="$bill->status === 'paid' ? 'positive' : ($bill->status === 'partial' ? 'warning' : 'negative')">
                            {{ ucfirst($bill->status) }}
                        </x-badge>
                    </div>

                    @if ($bill->payments->isNotEmpty())
                        <div class="mt-3 pt-3 border-t border-[#f1f5f9] space-y-1">
                            @foreach ($bill->payments as $payment)
                                <div class="text-xs text-[#64748b] flex justify-between">
                                    <span>{{ $payment->payment_date?->format('M j, Y') }} &middot; {{ ucfirst(str_replace('_', ' ', $payment->method)) }}</span>
                                    <span class="text-[#1e293b] font-medium">₱{{ number_format($payment->amount, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-xl border border-[#e2e8f0] px-5 py-6 text-center text-[#64748b]">No bills yet.</div>
            @endforelse
        </div>
    @endif
</x-tenant-layout>
