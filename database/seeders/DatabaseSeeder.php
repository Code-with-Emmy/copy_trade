<?php

namespace Database\Seeders;

use App\Models\Adverts;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('adverts')) {
            Adverts::factory(7)->create();
        }

        $this->call([
            CopytradingSeeder::class,
            FintechPlatformSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}
