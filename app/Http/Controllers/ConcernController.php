<?php

namespace App\Http\Controllers;

use App\Models\Concern;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConcernController extends Controller
{
    public function index(Request $request): View
    {
        $query = Concern::with('tenant', 'unit.property');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $concerns = $query->orderByRaw("CASE priority WHEN 'high' THEN 0 WHEN 'medium' THEN 1 ELSE 2 END")
            ->orderByDesc('reported_date')
            ->get();

        return view('concerns.index', compact('concerns'));
    }

    public function create(): View
    {
        $tenants = Tenant::with('unit')->orderBy('name')->get();
        $units = Unit::with('property')->orderBy('property_id')->orderBy('name')->get();

        return view('concerns.create', compact('tenants', 'units'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Concern::create($data);

        return redirect()->route('concerns.index')->with('status', 'Concern logged.');
    }

    public function edit(Concern $concern): View
    {
        $tenants = Tenant::with('unit')->orderBy('name')->get();
        $units = Unit::with('property')->orderBy('property_id')->orderBy('name')->get();

        return view('concerns.edit', compact('concern', 'tenants', 'units'));
    }

    public function update(Request $request, Concern $concern): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($data['status'] === 'resolved' && $concern->status !== 'resolved' && empty($data['resolved_date'])) {
            $data['resolved_date'] = now()->toDateString();
        }

        $concern->update($data);

        return redirect()->route('concerns.index')->with('status', 'Concern updated.');
    }

    public function destroy(Concern $concern): RedirectResponse
    {
        $concern->delete();

        return redirect()->route('concerns.index')->with('status', 'Concern deleted.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'unit_id' => ['nullable', 'exists:units,id'],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'resolution' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:open,in_progress,resolved'],
            'reported_date' => ['nullable', 'date'],
            'resolved_date' => ['nullable', 'date'],
        ]);
    }
}
