<?php

namespace Database\Seeders;

use App\Models\Offering;
use Illuminate\Database\Seeder;

class OfferingSeeder extends Seeder
{
    public function run(): void
    {
        $offerings = [
            [
                'name'        => 'Residential Property Sale',
                'description' => 'Full-service brokerage for buying and selling residential properties including apartments, villas, and townhouses. Includes market valuation, listing, showings, and closing support.',
                'price'       => 3500.00,
            ],
            [
                'name'        => 'Commercial Property Sale',
                'description' => 'End-to-end support for commercial real estate transactions including office spaces, retail units, and industrial properties. Includes due diligence and negotiation.',
                'price'       => 8500.00,
            ],
            [
                'name'        => 'Long-Term Residential Lease',
                'description' => 'Tenant sourcing, lease drafting, background checks, and move-in coordination for long-term residential rentals (12+ months).',
                'price'       => 1200.00,
            ],
            [
                'name'        => 'Short-Term & Holiday Rental Management',
                'description' => 'Full management of short-term holiday rentals including listing on platforms, guest communication, cleaning coordination, and financial reporting.',
                'price'       => 950.00,
            ],
            [
                'name'        => 'Property Valuation & Appraisal',
                'description' => 'Professional market valuation report for residential or commercial properties, including comparative market analysis and condition assessment.',
                'price'       => 450.00,
            ],
            [
                'name'        => 'Property Management (Monthly)',
                'description' => 'Ongoing monthly management of leased properties including rent collection, maintenance coordination, tenant communication, and monthly owner reporting.',
                'price'       => 350.00,
            ],
            [
                'name'        => 'Property Renovation Consultancy',
                'description' => 'Expert advice and project coordination for property renovation and refurbishment to increase market value. Includes contractor sourcing and timeline management.',
                'price'       => 2200.00,
            ],
            [
                'name'        => 'Investment Portfolio Advisory',
                'description' => 'Strategic advisory service for real estate investors. Includes market analysis, ROI projections, risk assessment, and portfolio diversification planning.',
                'price'       => 5000.00,
            ],
            [
                'name'        => 'Legal Contract & Documentation Service',
                'description' => 'Drafting, reviewing, and notarizing property contracts, lease agreements, and title transfer documents in compliance with Dutch real estate law.',
                'price'       => 750.00,
            ],
            [
                'name'        => 'Virtual Property Tour Production',
                'description' => 'Production of high-quality virtual 3D tours and aerial drone photography for property listings to attract remote buyers and tenants.',
                'price'       => 600.00,
            ],
        ];

        foreach ($offerings as $offering) {
            Offering::create($offering);
        }
    }
}
