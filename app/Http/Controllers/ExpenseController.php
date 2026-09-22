<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Expense::with('property');

        if ($request->filled('property_id')) {
            $query->where('property_id', $request->input('property_id'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        if ($request->filled('from')) {
            $query->whereDate('expense_date', '>=', $request->date('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('expense_date', '<=', $request->date('to'));
        }

        $expenses = $query->orderByDesc('expense_date')->orderByDesc('id')->get();
        $totalAmount = $expenses->sum('amount');

        $properties = Property::orderBy('name')->get();

        return view('expenses.index', compact('expenses', 'totalAmount', 'properties'));
    }

    public function create(): View
    {
        $properties = Property::orderBy('name')->get();

        return view('expenses.create', compact('properties'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        Expense::create($data);

        return redirect()->route('expenses.index')->with('status', 'Expense added.');
    }

    public function edit(Expense $expense): View
    {
        $properties = Property::orderBy('name')->get();

        return view('expenses.edit', compact('expense', 'properties'));
    }

    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $data = $this->validateData($request);

        $expense->update($data);

        return redirect()->route('expenses.index')->with('status', 'Expense updated.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $expense->delete();

        return redirect()->route('expenses.index')->with('status', 'Expense deleted.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'property_id' => ['nullable', 'exists:properties,id'],
            'category' => ['required', 'in:maintenance,utilities,supplies,salaries,marketing,taxes,other'],
            'description' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expense_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
