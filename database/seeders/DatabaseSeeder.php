<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Concern;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('ADMIN_PASSWORD', 'password');

        User::query()->updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin',
                'password' => $adminPassword,
            ]
        );

        if (Property::count() > 0) {
            return;
        }

        // A few sample records so the dashboard isn't empty on first run.
        $property = Property::create([
            'name' => 'Sample Apartment Building',
            'address' => 'Cebu City, Philippines',
            'notes' => 'You can rename or delete this sample data any time.',
        ]);

        $unit1 = Unit::create([
            'property_id' => $property->id,
            'name' => 'Unit 1',
            'monthly_rent' => 8000,
            'status' => 'occupied',
        ]);

        $unit2 = Unit::create([
            'property_id' => $property->id,
            'name' => 'Unit 2',
            'monthly_rent' => 7500,
            'status' => 'vacant',
        ]);

        $tenant = Tenant::create([
            'unit_id' => $unit1->id,
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@example.com',
            'password' => 'tenant123',
            'phone' => '0917-000-0000',
            'move_in_date' => now()->subMonths(3)->toDateString(),
            'status' => 'active',
        ]);

        $rentBill = Bill::create([
            'unit_id' => $unit1->id,
            'type' => 'rent',
            'description' => 'Monthly rent',
            'amount' => 8000,
            'billing_period' => now()->startOfMonth()->toDateString(),
            'due_date' => now()->startOfMonth()->addDays(4)->toDateString(),
            'status' => 'partial',
        ]);

        Bill::create([
            'unit_id' => $unit1->id,
            'type' => 'electricity',
            'description' => 'Electric bill',
            'amount' => 1200,
            'billing_period' => now()->startOfMonth()->toDateString(),
            'due_date' => now()->startOfMonth()->addDays(10)->toDateString(),
            'status' => 'unpaid',
        ]);

        Payment::create([
            'bill_id' => $rentBill->id,
            'tenant_id' => $tenant->id,
            'amount' => 4000,
            'payment_date' => now()->subDays(2)->toDateString(),
            'method' => 'gcash',
            'reference_no' => 'REF12345',
        ]);

        $rentBill->refreshStatus();

        Concern::create([
            'tenant_id' => $tenant->id,
            'unit_id' => $unit1->id,
            'subject' => 'Leaking faucet in kitchen',
            'description' => 'Tenant reports a slow leak under the kitchen sink.',
            'priority' => 'medium',
            'status' => 'open',
            'reported_date' => now()->subDays(1)->toDateString(),
        ]);

        Concern::create([
            'tenant_id' => $tenant->id,
            'unit_id' => $unit1->id,
            'subject' => 'Aircon not cooling',
            'description' => 'The bedroom aircon runs but does not cool the room anymore.',
            'resolution' => 'Technician cleaned the filters and recharged the refrigerant on Sep 18. Confirmed cooling normally afterward.',
            'priority' => 'high',
            'status' => 'resolved',
            'reported_date' => now()->subDays(6)->toDateString(),
            'resolved_date' => now()->subDays(2)->toDateString(),
        ]);
    }
}
