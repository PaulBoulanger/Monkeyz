<?php

use Illuminate\Database\Seeder;

class BasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 50; $i++) {
            App\Base::create([
                'user_id' => $i,
                'position_x' => rand(1, 100),
                'position_y' => rand(1, 100),
            ]);
        }
    }
}
