<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BillController extends Controller
{
    public function index(): View
    {
        $tenant = Auth::guard('tenant')->user();

        $bills = collect();
        if ($tenant->unit_id) {
            $bills = Bill::where('unit_id', $tenant->unit_id)
                ->with('payments')
                ->orderByDesc('due_date')
                ->get();
        }

        return view('tenant.bills.index', compact('bills', 'tenant'));
    }
}
