<?php

namespace App\Http\Controllers;

use App\Mail\NewBillMail;
use App\Models\Bill;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class BillController extends Controller
{
    public function index(Request $request): View
    {
        $query = Bill::with('unit.property', 'payments');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $bills = $query->orderByDesc('due_date')->get();

        return view('bills.index', compact('bills'));
    }

    public function create(): View
    {
        $units = Unit::with('property')->orderBy('property_id')->orderBy('name')->get();

        return view('bills.create', compact('units'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        $bill = Bill::create($data);

        $this->notifyTenant($bill);

        return redirect()->route('bills.index')->with('status', 'Bill added.');
    }

    public function edit(Bill $bill): View
    {
        $units = Unit::with('property')->orderBy('property_id')->orderBy('name')->get();

        return view('bills.edit', compact('bill', 'units'));
    }

    public function update(Request $request, Bill $bill): RedirectResponse
    {
        $data = $this->validateData($request);

        $bill->update($data);
        $bill->refreshStatus();

        return redirect()->route('bills.index')->with('status', 'Bill updated.');
    }

    public function destroy(Bill $bill): RedirectResponse
    {
        $bill->delete();

        return redirect()->route('bills.index')->with('status', 'Bill deleted.');
    }

    private function notifyTenant(Bill $bill): void
    {
        $tenant = $bill->unit?->currentTenant;

        if (! $tenant || ! $tenant->email) {
            return;
        }

        try {
            Mail::to($tenant->email)->send(new NewBillMail($bill->load('unit.property')));
        } catch (\Throwable $e) {
            // Never let a broken mail setup stop a bill from being saved.
            Log::warning('Failed to send new bill email: '.$e->getMessage());
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'unit_id' => ['required', 'exists:units,id'],
            'type' => ['required', 'in:rent,electricity,water,internet,other'],
            'description' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'billing_period' => ['nullable', 'date'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'in:unpaid,partial,paid'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
