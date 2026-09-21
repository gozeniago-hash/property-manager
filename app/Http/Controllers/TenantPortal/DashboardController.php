<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
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

        $unpaidTotal = $bills->filter(fn (Bill $b) => $b->status !== 'paid')->sum(fn (Bill $b) => $b->balance());
        $openConcerns = $tenant->concerns()->whereIn('status', ['open', 'in_progress'])->count();

        return view('tenant.dashboard', [
            'tenant' => $tenant,
            'bills' => $bills->take(5),
            'unpaidTotal' => $unpaidTotal,
            'openConcerns' => $openConcerns,
        ]);
    }
}
