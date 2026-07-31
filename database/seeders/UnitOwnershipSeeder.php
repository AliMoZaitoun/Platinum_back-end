<?php

namespace Database\Seeders;

use App\Models\Legal\Contract;
use App\Models\Sales\UnitOwnership;
use Illuminate\Database\Seeder;

class UnitOwnershipSeeder extends Seeder
{
    public function run(): void
    {
        $activeContracts = Contract::with('order')->where('status', 'active')->get();

        foreach ($activeContracts as $contract) {
            if ($contract->order && $contract->order->unit_id) {
                UnitOwnership::create([
                    'client_id'      => $contract->client_id,
                    'unit_id'        => $contract->order->unit_id,
                    'purchase_price' => $contract->total_price,
                    'status'         => 'active',
                    'owned_at'       => now()->subDays(10)->toDateString(),
                ]);
            }
        }
    }
}
