<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Bill $bill): RedirectResponse
    {
        $data = $request->validate([
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_date' => ['required', 'date'],
            'method' => ['required', 'in:cash,bank_transfer,gcash,other'],
            'reference_no' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['bill_id'] = $bill->id;

        Payment::create($data);

        $bill->refreshStatus();

        return redirect()->back()->with('status', 'Payment recorded.');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $bill = $payment->bill;

        $payment->delete();

        if ($bill) {
            $bill->refreshStatus();
        }

        return redirect()->back()->with('status', 'Payment removed.');
    }
}
