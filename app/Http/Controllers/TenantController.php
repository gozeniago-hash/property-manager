<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TenantController extends Controller
{
    public function index(): View
    {
        $tenants = Tenant::with('unit.property')->orderByDesc('status')->orderBy('name')->get();

        return view('tenants.index', compact('tenants'));
    }

    public function create(): View
    {
        $units = Unit::with('property')->orderBy('property_id')->orderBy('name')->get();

        return view('tenants.create', compact('units'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->filled('portal_password')) {
            $data['password'] = Hash::make($request->string('portal_password'));
        }

        $tenant = Tenant::create($data);

        $this->syncUnitStatus($tenant);

        return redirect()->route('tenants.index')->with('status', 'Tenant added.');
    }

    public function show(Tenant $tenant): View
    {
        $tenant->load('unit.property', 'payments.bill', 'concerns');

        return view('tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant): View
    {
        $units = Unit::with('property')->orderBy('property_id')->orderBy('name')->get();

        return view('tenants.edit', compact('tenant', 'units'));
    }

    public function update(Request $request, Tenant $tenant): RedirectResponse
    {
        $previousUnitId = $tenant->unit_id;

        $data = $this->validateData($request);

        if ($request->filled('portal_password')) {
            $data['password'] = Hash::make($request->string('portal_password'));
        }

        $tenant->update($data);

        $this->syncUnitStatus($tenant, $previousUnitId);

        return redirect()->route('tenants.index')->with('status', 'Tenant updated.');
    }

    public function destroy(Tenant $tenant): RedirectResponse
    {
        $unitId = $tenant->unit_id;

        $tenant->delete();

        if ($unitId) {
            $this->refreshUnitOccupancy($unitId);
        }

        return redirect()->route('tenants.index')->with('status', 'Tenant deleted.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'unit_id' => ['nullable', 'exists:units,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'move_in_date' => ['nullable', 'date'],
            'move_out_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,former'],
            'notes' => ['nullable', 'string'],
            'portal_password' => ['nullable', 'string', 'min:6'],
        ]);

        // portal_password is validated here (so bad input is rejected) but is not
        // a real tenants column — it's applied separately as a hash, so strip it
        // before this array is used for mass assignment.
        unset($data['portal_password']);

        return $data;
    }

    private function syncUnitStatus(Tenant $tenant, ?int $previousUnitId = null): void
    {
        if ($previousUnitId && $previousUnitId !== $tenant->unit_id) {
            $this->refreshUnitOccupancy($previousUnitId);
        }

        if ($tenant->unit_id) {
            $this->refreshUnitOccupancy($tenant->unit_id);
        }
    }

    private function refreshUnitOccupancy(int $unitId): void
    {
        $unit = Unit::find($unitId);

        if (! $unit) {
            return;
        }

        $hasActiveTenant = $unit->tenants()->where('status', 'active')->exists();

        $unit->update(['status' => $hasActiveTenant ? 'occupied' : 'vacant']);
    }
}
