<x-tenant-layout title="Dashboard">
    <div class="mb-6 text-sm text-[#475569]">
        Welcome back, <span class="font-medium text-[#1e293b]">{{ $tenant->name }}</span>.
        @if ($tenant->unit)
            You're renting <span class="font-medium text-[#1e293b]">{{ $tenant->unit->property->name }} / {{ $tenant->unit->name }}</span>.
        @endif
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Outstanding balance</div>
            <div class="text-2xl font-semibold {{ $unpaidTotal > 0 ? 'text-[#9f2d42]' : 'text-[#0f172a]' }} mt-1">
                ₱{{ number_format($unpaidTotal, 2) }}
            </div>
        </div>
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Open concerns</div>
            <div class="text-2xl font-semibold text-[#0f172a] mt-1">{{ $openConcerns }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-[#e2e8f0]">
        <div class="px-5 py-4 border-b border-[#e2e8f0] flex items-center justify-between">
            <h2 class="font-semibold text-[#0f172a]">Recent Bills</h2>
            <a href="{{ route('tenant.bills.index') }}" class="text-sm text-[#4f46e5] hover:underline">View all</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($bills as $bill)
                <div class="px-5 py-3 text-sm flex items-center justify-between">
                    <div>
                        <div class="font-medium text-[#1e293b]">{{ ucfirst($bill->type) }}</div>
                        <div class="text-xs text-[#64748b]">Due {{ $bill->due_date?->format('M j, Y') }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-[#0f172a]">₱{{ number_format($bill->amount, 2) }}</div>
                        <x-badge :tone="$bill->status === 'paid' ? 'positive' : ($bill->status === 'partial' ? 'warning' : 'negative')">
                            {{ ucfirst($bill->status) }}
                        </x-badge>
                    </div>
                </div>
            @empty
                <div class="px-5 py-6 text-sm text-[#64748b]">No bills yet.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('tenant.concerns.create') }}" class="inline-block bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">
            + Raise a Concern
        </a>
    </div>
</x-tenant-layout>
