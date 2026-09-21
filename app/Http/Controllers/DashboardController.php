<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Concern;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Unit;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProperties = Property::count();
        $totalUnits = Unit::count();
        $occupiedUnits = Unit::where('status', 'occupied')->count();
        $activeTenants = Tenant::where('status', 'active')->count();

        $unpaidBills = Bill::whereIn('status', ['unpaid', 'partial'])->with('unit.property', 'payments')->get();
        $unpaidCount = $unpaidBills->count();
        $unpaidTotal = $unpaidBills->sum(fn (Bill $bill) => $bill->balance());

        $overdueBills = $unpaidBills->filter(fn (Bill $bill) => $bill->due_date && $bill->due_date->isPast());

        $openConcerns = Concern::whereIn('status', ['open', 'in_progress'])
            ->with('tenant', 'unit.property')
            ->orderByDesc('priority')
            ->get();

        $recentPayments = Payment::with('bill.unit.property', 'tenant')
            ->latest('payment_date')
            ->latest('id')
            ->take(8)
            ->get();

        return view('dashboard', [
            'totalProperties' => $totalProperties,
            'totalUnits' => $totalUnits,
            'occupiedUnits' => $occupiedUnits,
            'activeTenants' => $activeTenants,
            'unpaidCount' => $unpaidCount,
            'unpaidTotal' => $unpaidTotal,
            'overdueBills' => $overdueBills,
            'openConcerns' => $openConcerns,
            'recentPayments' => $recentPayments,
        ]);
    }
}
