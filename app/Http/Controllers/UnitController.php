<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UnitController extends Controller
{
    public function index(): View
    {
        $units = Unit::with('property', 'currentTenant')->orderBy('property_id')->orderBy('name')->get();

        return view('units.index', compact('units'));
    }

    public function create(): View
    {
        $properties = Property::orderBy('name')->get();

        return view('units.create', compact('properties'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Unit::create($data);

        return redirect()->route('units.index')->with('status', 'Unit added.');
    }

    public function edit(Unit $unit): View
    {
        $properties = Property::orderBy('name')->get();

        return view('units.edit', compact('unit', 'properties'));
    }

    public function update(Request $request, Unit $unit): RedirectResponse
    {
        $data = $this->validateData($request);

        $unit->update($data);

        return redirect()->route('units.index')->with('status', 'Unit updated.');
    }

    public function destroy(Unit $unit): RedirectResponse
    {
        $unit->delete();

        return redirect()->route('units.index')->with('status', 'Unit deleted.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'property_id' => ['required', 'exists:properties,id'],
            'name' => ['required', 'string', 'max:255'],
            'monthly_rent' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:vacant,occupied'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
