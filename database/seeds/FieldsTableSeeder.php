<?php

use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 50; $i++) {
            App\Field::create([
                'user_id' => $i,
                'fields' => rand(50, 1000),
                'units' => rand(0, 10000),
            ]);
        }
    }
}
