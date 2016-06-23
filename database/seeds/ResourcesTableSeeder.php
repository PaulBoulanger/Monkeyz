<?php

use Illuminate\Database\Seeder;

class ResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 50; $i++) {
            App\Resource::create([
                'user_id' => $i,
                'units' => rand(0, 10000),
            ]);
        }
    }
}
