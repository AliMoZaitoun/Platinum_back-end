<?php

namespace Database\Seeders;

use App\Models\Core\Employee;
use App\Models\Sales\AvailabilitySlot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AvailabilitySlotSeeder extends Seeder
{
    public function run(): void
    {
        $legalEmployees = Employee::whereHas('user', function ($query) {
            $query->role('legal_staff');
        })->get();

        if ($legalEmployees->isEmpty()) {
            $legalEmployees = Employee::whereHas('departments', function ($q) {
                $q->where('name->en', 'Legal & Contracts');
            })->get();
        }

        foreach ($legalEmployees as $employee) {
            for ($i = 1; $i <= 5; $i++) {
                $batchId = (string) Str::uuid();
                $date = now()->addDays($i)->format('Y-m-d');

                foreach (['09:00:00', '11:00:00', '14:00:00'] as $time) {
                    AvailabilitySlot::create([
                        'employee_id' => $employee->id,
                        'date'        => $date,
                        'batch_id'    => $batchId,
                        'start_time'  => $time,
                        'status'      => 'available',
                    ]);
                }
            }
        }
    }
}
