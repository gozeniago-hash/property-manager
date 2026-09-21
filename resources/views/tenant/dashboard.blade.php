<x-tenant-layout title="Dashboard">
    <div class="mb-6 text-sm text-slate-600">
        Welcome back, <span class="font-medium text-slate-800">{{ $tenant->name }}</span>.
        @if ($tenant->unit)
            You're renting <span class="font-medium text-slate-800">{{ $tenant->unit->property->name }} / {{ $tenant->unit->name }}</span>.
        @endif
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="text-xs text-slate-500 uppercase tracking-wide">Outstanding balance</div>
            <div class="text-2xl font-semibold {{ $unpaidTotal > 0 ? 'text-red-600' : 'text-slate-900' }} mt-1">
                ₱{{ number_format($unpaidTotal, 2) }}
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="text-xs text-slate-500 uppercase tracking-wide">Open concerns</div>
            <div class="text-2xl font-semibold text-slate-900 mt-1">{{ $openConcerns }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="font-semibold text-slate-900">Recent Bills</h2>
            <a href="{{ route('tenant.bills.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($bills as $bill)
                <div class="px-5 py-3 text-sm flex items-center justify-between">
                    <div>
                        <div class="font-medium text-slate-800">{{ ucfirst($bill->type) }}</div>
                        <div class="text-xs text-slate-500">Due {{ $bill->due_date?->format('M j, Y') }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-slate-900">₱{{ number_format($bill->amount, 2) }}</div>
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $bill->status === 'paid' ? 'bg-green-100 text-green-700' : ($bill->status === 'partial' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($bill->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="px-5 py-6 text-sm text-slate-500">No bills yet.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('tenant.concerns.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2">
            + Raise a Concern
        </a>
    </div>
</x-tenant-layout>
