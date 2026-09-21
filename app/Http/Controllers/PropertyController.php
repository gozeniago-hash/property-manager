<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(): View
    {
        $properties = Property::withCount('units')
            ->with(['units' => fn ($q) => $q->where('status', 'occupied')])
            ->orderBy('name')
            ->get();

        return view('properties.index', compact('properties'));
    }

    public function create(): View
    {
        return view('properties.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Property::create($data);

        return redirect()->route('properties.index')->with('status', 'Property added.');
    }

    public function show(Property $property): View
    {
        $property->load('units.currentTenant');

        return view('properties.show', compact('property'));
    }

    public function edit(Property $property): View
    {
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property): RedirectResponse
    {
        $data = $this->validateData($request);

        $property->update($data);

        return redirect()->route('properties.index')->with('status', 'Property updated.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property->delete();

        return redirect()->route('properties.index')->with('status', 'Property deleted.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
