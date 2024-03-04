<?php

namespace Database\Seeders;

use App\Models\PromotionalEventCharge;
use Illuminate\Database\Seeder;

class PromotionalEventPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            PromotionalEventCharge::create([
                'id' => 1,
                'charge' => 1000,
            ]);
    }
}