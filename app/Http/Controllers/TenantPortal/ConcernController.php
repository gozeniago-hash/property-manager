<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\Concern;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConcernController extends Controller
{
    public function index(): View
    {
        $tenant = Auth::guard('tenant')->user();

        $concerns = $tenant->concerns()->orderByDesc('reported_date')->orderByDesc('id')->get();

        return view('tenant.concerns.index', compact('concerns'));
    }

    public function create(): View
    {
        return view('tenant.concerns.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = Auth::guard('tenant')->user();

        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
        ]);

        $data['tenant_id'] = $tenant->id;
        $data['unit_id'] = $tenant->unit_id;
        $data['status'] = 'open';
        $data['reported_date'] = now()->toDateString();

        $concern = Concern::create($data);

        return redirect()->route('tenant.concerns.show', $concern)->with('status', 'Your concern has been submitted.');
    }

    public function show(Concern $concern): View
    {
        $tenant = Auth::guard('tenant')->user();

        if ($concern->tenant_id !== $tenant->id) {
            throw new NotFoundHttpException;
        }

        return view('tenant.concerns.show', compact('concern'));
    }
}
