<?php

namespace Database\Seeders;

use App\Models\Legal\Contract;
use App\Models\Sales\UnitOwnership;
use Illuminate\Database\Seeder;

class UnitOwnershipSeeder extends Seeder
{
    public function run(): void
    {
        $contracts = Contract::where('status', 'active')->get();

        foreach ($contracts as $contract) {
            if ($contract->order && $contract->order->unit_id) {
                UnitOwnership::create([
                    'client_id'      => $contract->client_id,
                    'unit_id'        => $contract->order->unit_id,
                    'purchase_price' => $contract->total_price,
                    'status'         => 'active',
                    'owned_at'       => now()->toDateString(),
                ]);
            }
        }
    }
}
