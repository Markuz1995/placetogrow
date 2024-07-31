<?php

namespace Database\Seeders;

use App\Domains\Microsite\Models\Microsite;
use App\Domains\PaymentRecord\Models\PaymentRecord;
use Illuminate\Database\Seeder;

class MicrositeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Microsite::factory()->count(10)->create()->each(function ($microsite) {
            PaymentRecord::factory()->count(3)->create([
                'microsite_id' => $microsite->id,
                'type' => $microsite->type
            ]);
        });
    }
}
