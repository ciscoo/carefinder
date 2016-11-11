<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Hospital::class, 200)->create();
        $this->call(HospitalTableSeeder::class);
    }
}
