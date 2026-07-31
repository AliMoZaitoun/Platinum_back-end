<?php

namespace Database\Seeders;

use App\Models\Client\Client;
use App\Models\Core\Department;
use App\Models\RealEstate\Solution;
use App\Models\RealEstate\Unit;
use App\Models\Sales\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();
        $units = Unit::limit(5)->get();
        $solutions = Solution::limit(3)->get();

        $customerServiceDept = Department::where('name->en', 'Customer Service')->first();

        if ($clients->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'initially_accepted', 'accepted', 'rejected'];

        foreach ($clients as $index => $client) {
            Order::create([
                'client_id'     => $client->id,
                'unit_id'       => $units->get($index % max(1, $units->count()))?->id,
                'solution_id'   => $index % 2 === 0 ? null : $solutions->first()?->id,
                'department_id' => $customerServiceDept?->id,
                'status'        => $statuses[$index % count($statuses)],
            ]);
        }
    }
}
