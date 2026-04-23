<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = Warehouse::all();

        $items = [
            // Documents Archive (warehouse 1)
            [
                'warehouse_id'  => $warehouses[0]->id,
                'sku'           => 'DOC-TITLE-001',
                'name'          => 'Property Title Deed Files',
                'description'   => 'Original title deed documents for all managed properties.',
                'quantity'      => 320,
                'status'        => 'in_stock',
                'purchase_date' => '2020-01-15',
                'received_date' => '2020-01-16',
                'expiry_date'   => null,
            ],
            [
                'warehouse_id'  => $warehouses[0]->id,
                'sku'           => 'DOC-LEASE-001',
                'name'          => 'Signed Lease Agreements',
                'description'   => 'Archived signed lease contracts for residential and commercial units.',
                'quantity'      => 540,
                'status'        => 'in_stock',
                'purchase_date' => '2021-03-10',
                'received_date' => '2021-03-11',
                'expiry_date'   => null,
            ],
            [
                'warehouse_id'  => $warehouses[0]->id,
                'sku'           => 'DOC-INSPEC-001',
                'name'          => 'Property Inspection Reports',
                'description'   => 'Completed inspection reports including photos and compliance checks.',
                'quantity'      => 215,
                'status'        => 'in_stock',
                'purchase_date' => '2022-06-01',
                'received_date' => '2022-06-02',
                'expiry_date'   => null,
            ],

            // Equipment Storage (warehouse 2)
            [
                'warehouse_id'  => $warehouses[1]->id,
                'sku'           => 'EQP-LOCKBOX-001',
                'name'          => 'Property Lockboxes',
                'description'   => 'Combination lockboxes used for key access during property showings.',
                'quantity'      => 75,
                'status'        => 'in_stock',
                'purchase_date' => '2023-02-20',
                'received_date' => '2023-02-22',
                'expiry_date'   => null,
            ],
            [
                'warehouse_id'  => $warehouses[1]->id,
                'sku'           => 'EQP-DRONE-001',
                'name'          => 'Aerial Photography Drones',
                'description'   => 'DJI drones used for aerial property and development site photography.',
                'quantity'      => 5,
                'status'        => 'in_stock',
                'purchase_date' => '2023-07-15',
                'received_date' => '2023-07-18',
                'expiry_date'   => null,
            ],
            [
                'warehouse_id'  => $warehouses[1]->id,
                'sku'           => 'EQP-MEAS-001',
                'name'          => 'Laser Distance Measurers',
                'description'   => 'Bosch laser measure tools for site and unit measurements.',
                'quantity'      => 0,
                'status'        => 'out_of_stock',
                'purchase_date' => '2022-11-05',
                'received_date' => '2022-11-06',
                'expiry_date'   => null,
            ],

            // Furniture & Staging (warehouse 3)
            [
                'warehouse_id'  => $warehouses[2]->id,
                'sku'           => 'FURN-SOFA-001',
                'name'          => 'Staging Sofas',
                'description'   => 'Modern neutral-tone sofas used for property staging and open houses.',
                'quantity'      => 18,
                'status'        => 'in_stock',
                'purchase_date' => '2023-01-10',
                'received_date' => '2023-01-12',
                'expiry_date'   => null,
            ],
            [
                'warehouse_id'  => $warehouses[2]->id,
                'sku'           => 'FURN-TABLE-001',
                'name'          => 'Dining & Conference Tables',
                'description'   => 'Foldable tables for staging dining rooms and meeting spaces.',
                'quantity'      => 0,
                'status'        => 'discontinued',
                'purchase_date' => '2023-01-10',
                'received_date' => '2023-01-12',
                'expiry_date'   => null,
            ],

            // Construction Materials (warehouse 4)
            [
                'warehouse_id'  => $warehouses[3]->id,
                'sku'           => 'CONS-PAINT-001',
                'name'          => 'Interior Paint (White & Neutral)',
                'description'   => 'Sigma paint in white and warm grey tones for property refurbishment.',
                'quantity'      => 200,
                'status'        => 'in_stock',
                'purchase_date' => '2024-03-01',
                'received_date' => '2024-03-03',
                'expiry_date'   => '2026-03-01',
            ],
            [
                'warehouse_id'  => $warehouses[3]->id,
                'sku'           => 'CONS-FLRTILE-001',
                'name'          => 'Ceramic Floor Tiles (60x60)',
                'description'   => 'Standard ceramic floor tiles used in unit renovations.',
                'quantity'      => 0,
                'status'        => 'out_of_stock',
                'purchase_date' => '2024-04-10',
                'received_date' => '2024-04-12',
                'expiry_date'   => null,
            ],

            // IT & Office Equipment (warehouse 5)
            [
                'warehouse_id'  => $warehouses[4]->id,
                'sku'           => 'IT-LAPTOP-001',
                'name'          => 'Agent Laptops',
                'description'   => 'Dell Latitude laptops assigned to field agents and sales staff.',
                'quantity'      => 30,
                'status'        => 'in_stock',
                'purchase_date' => '2023-09-01',
                'received_date' => '2023-09-03',
                'expiry_date'   => null,
            ],
            [
                'warehouse_id'  => $warehouses[4]->id,
                'sku'           => 'IT-TABLET-001',
                'name'          => 'Property Showcase Tablets',
                'description'   => 'iPads used during open houses for digital brochures and 3D tour demos.',
                'quantity'      => 0,
                'status'        => 'discontinued',
                'purchase_date' => '2023-09-01',
                'received_date' => '2023-09-03',
                'expiry_date'   => null,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
