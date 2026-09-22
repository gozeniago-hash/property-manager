<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->filled('from')
            ? Carbon::parse($request->input('from'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $to = $request->filled('to')
            ? Carbon::parse($request->input('to'))->endOfDay()
            : Carbon::now()->endOfMonth();

        $propertyId = $request->input('property_id');

        // Total income: everything billed to tenants in the period.
        $billsQuery = Bill::query()->whereBetween('due_date', [$from->toDateString(), $to->toDateString()]);
        if ($propertyId) {
            $billsQuery->whereHas('unit', fn ($q) => $q->where('property_id', $propertyId));
        }
        $bills = $billsQuery->with('unit.property')->get();
        $totalIncome = (float) $bills->sum('amount');

        // Collected: actual payments received in the period.
        $paymentsQuery = Payment::query()->whereBetween('payment_date', [$from->toDateString(), $to->toDateString()]);
        if ($propertyId) {
            $paymentsQuery->whereHas('bill.unit', fn ($q) => $q->where('property_id', $propertyId));
        }
        $payments = $paymentsQuery->with('bill.unit.property')->get();
        $collected = (float) $payments->sum('amount');

        // Collectibles: money still owed on bills due within the period (not yet fully paid).
        $collectibles = (float) $bills->sum(fn (Bill $bill) => max($bill->balance(), 0));

        // Expenses, for a fuller picture alongside income.
        $expensesQuery = Expense::query()->whereBetween('expense_date', [$from->toDateString(), $to->toDateString()]);
        if ($propertyId) {
            $expensesQuery->where('property_id', $propertyId);
        }
        $expenses = $expensesQuery->get();
        $totalExpenses = (float) $expenses->sum('amount');

        $netCashFlow = $collected - $totalExpenses;

        // Expense report: totals by category, for the period (and property, if filtered).
        $expensesByCategory = $expenses->groupBy('category')
            ->map(fn ($group, $category) => [
                'category' => $category,
                'amount' => (float) $group->sum('amount'),
            ])
            ->sortByDesc('amount')
            ->values();

        // Breakdown by property — income, collections, and expenses, rolled up into net income.
        $properties = Property::orderBy('name')->get();
        $byProperty = $properties->map(function (Property $property) use ($bills, $payments, $expenses) {
            $propertyBills = $bills->filter(fn (Bill $bill) => optional($bill->unit)->property_id === $property->id);
            $propertyPayments = $payments->filter(fn (Payment $payment) => optional(optional($payment->bill)->unit)->property_id === $property->id);
            $propertyExpenses = $expenses->filter(fn (Expense $expense) => $expense->property_id === $property->id);

            $propertyIncome = (float) $propertyBills->sum('amount');
            $propertyCollected = (float) $propertyPayments->sum('amount');
            $propertyExpenseTotal = (float) $propertyExpenses->sum('amount');

            return [
                'property' => $property,
                'income' => $propertyIncome,
                'collected' => $propertyCollected,
                'collectibles' => (float) $propertyBills->sum(fn (Bill $bill) => max($bill->balance(), 0)),
                'expenses' => $propertyExpenseTotal,
                'net_income' => $propertyIncome - $propertyExpenseTotal,
            ];
        })->filter(fn (array $row) => $row['income'] > 0 || $row['collected'] > 0 || $row['collectibles'] > 0 || $row['expenses'] > 0)->values();

        // Expenses not tied to any specific property (general/overhead costs).
        $generalExpenses = (float) $expenses->whereNull('property_id')->sum('amount');

        return view('reports.index', [
            'from' => $from,
            'to' => $to,
            'propertyId' => $propertyId,
            'properties' => $properties,
            'totalIncome' => $totalIncome,
            'collected' => $collected,
            'collectibles' => $collectibles,
            'totalExpenses' => $totalExpenses,
            'netCashFlow' => $netCashFlow,
            'netIncome' => $totalIncome - $totalExpenses,
            'expensesByCategory' => $expensesByCategory,
            'generalExpenses' => $generalExpenses,
            'byProperty' => $byProperty,
        ]);
    }
}
