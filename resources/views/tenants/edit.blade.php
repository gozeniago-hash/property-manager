<x-layout title="Edit Tenant">
    <form action="{{ route('tenants.update', $tenant) }}" method="POST" class="bg-white rounded-xl border border-[#e2e8f0] p-6 max-w-xl space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Full name</label>
            <input type="text" name="name" value="{{ old('name', $tenant->name) }}" required
                   class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $tenant->email) }}"
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $tenant->phone) }}"
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Unit</label>
            <select name="unit_id" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                <option value="">No unit assigned</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" @selected(old('unit_id', $tenant->unit_id) == $unit->id)>
                        {{ optional($unit->property)->name }} / {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Move-in date</label>
                <input type="date" name="move_in_date" value="{{ old('move_in_date', optional($tenant->move_in_date)->toDateString()) }}"
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
            <div>
                <label class="block text-sm font-medium text-[#1e293b] mb-1">Move-out date</label>
                <input type="date" name="move_out_date" value="{{ old('move_out_date', optional($tenant->move_out_date)->toDateString()) }}"
                       class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Status</label>
            <select name="status" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
                <option value="active" @selected(old('status', $tenant->status) === 'active')>Active</option>
                <option value="former" @selected(old('status', $tenant->status) === 'former')>Former</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Notes</label>
            <textarea name="notes" rows="3"
                      class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">{{ old('notes', $tenant->notes) }}</textarea>
        </div>
        <div class="pt-4 border-t border-[#f1f5f9]">
            <label class="block text-sm font-medium text-[#1e293b] mb-1">Tenant portal password</label>
            <input type="text" name="portal_password" value="{{ old('portal_password') }}" minlength="6"
                   placeholder="{{ $tenant->hasPortalAccess() ? 'Leave blank to keep current password' : 'Leave blank for no portal access yet' }}"
                   class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6366f1]">
            <p class="text-xs text-[#94a3b8] mt-1">
                @if ($tenant->hasPortalAccess())
                    This tenant currently has portal access. Enter a new password here to reset it.
                @else
                    This tenant does not have portal access yet. Set a password to let them log in with their email above.
                @endif
            </p>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-[#4f46e5] hover:bg-[#4338ca] text-white text-sm font-medium rounded-lg px-4 py-2">Update</button>
            <a href="{{ route('tenants.index') }}" class="text-sm text-[#475569] px-4 py-2">Cancel</a>
        </div>
    </form>
</x-layout>
