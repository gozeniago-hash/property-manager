<x-layout title="Reports">
    <form method="GET" class="flex flex-wrap items-end gap-3 mb-6 bg-white rounded-xl border border-[#e2e8f0] p-4">
        <div>
            <label class="block text-xs text-[#64748b] mb-1">Property</label>
            <select name="property_id" class="rounded-lg border border-[#cbd5e1] px-3 py-1.5 text-sm">
                <option value="">All properties</option>
                @foreach ($properties as $property)
                    <option value="{{ $property->id }}" @selected($propertyId == $property->id)>{{ $property->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-[#64748b] mb-1">From</label>
            <input type="date" name="from" value="{{ $from->toDateString() }}" class="rounded-lg border border-[#cbd5e1] px-3 py-1.5 text-sm">
        </div>
        <div>
            <label class="block text-xs text-[#64748b] mb-1">To</label>
            <input type="date" name="to" value="{{ $to->toDateString() }}" class="rounded-lg border border-[#cbd5e1] px-3 py-1.5 text-sm">
        </div>
        <button type="submit" class="bg-[#0f172a] hover:bg-[#1e293b] text-white text-sm font-medium rounded-lg px-4 py-2">Run report</button>
        <div class="text-xs text-[#64748b] ml-2 self-center">{{ $from->format('M j, Y') }} – {{ $to->format('M j, Y') }}</div>
    </form>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Total Income</div>
            <div class="text-2xl font-semibold text-[#0f172a] mt-1">₱{{ number_format($totalIncome, 2) }}</div>
            <div class="text-xs text-[#64748b] mt-0.5">Total billed in period</div>
        </div>
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Collected</div>
            <div class="text-2xl font-semibold text-[#0f172a] mt-1">₱{{ number_format($collected, 2) }}</div>
            <div class="text-xs text-[#64748b] mt-0.5">Payments actually received</div>
        </div>
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Collectibles</div>
            <div class="text-2xl font-semibold text-[#9f2d42] mt-1">₱{{ number_format($collectibles, 2) }}</div>
            <div class="text-xs text-[#64748b] mt-0.5">Still owed on bills due in period</div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Total Expenses</div>
            <div class="text-2xl font-semibold text-[#0f172a] mt-1">₱{{ number_format($totalExpenses, 2) }}</div>
        </div>
        <div class="bg-white rounded-xl border border-[#e2e8f0] p-4">
            <div class="text-xs text-[#64748b] uppercase tracking-wide">Net Cash Flow</div>
            <div class="text-2xl font-semibold {{ $netCashFlow >= 0 ? 'text-[#0f172a]' : 'text-[#9f2d42]' }} mt-1">
                ₱{{ number_format($netCashFlow, 2) }}
            </div>
            <div class="text-xs text-[#64748b] mt-0.5">Collected minus expenses</div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-[#e2e8f0] overflow-hidden">
        <div class="px-5 py-4 border-b border-[#e2e8f0]">
            <h2 class="font-semibold text-[#0f172a]">Breakdown by Property</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-[#f8fafc] text-left text-xs uppercase text-[#64748b]">
                <tr>
                    <th class="px-5 py-3">Property</th>
                    <th class="px-5 py-3">Income</th>
                    <th class="px-5 py-3">Collected</th>
                    <th class="px-5 py-3">Collectibles</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($byProperty as $row)
                    <tr>
                        <td class="px-5 py-3 font-medium text-[#1e293b]">{{ $row['property']->name }}</td>
                        <td class="px-5 py-3">₱{{ number_format($row['income'], 2) }}</td>
                        <td class="px-5 py-3">₱{{ number_format($row['collected'], 2) }}</td>
                        <td class="px-5 py-3 {{ $row['collectibles'] > 0 ? 'text-[#9f2d42] font-medium' : '' }}">₱{{ number_format($row['collectibles'], 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-6 text-center text-[#64748b]">No billing activity in this period.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
