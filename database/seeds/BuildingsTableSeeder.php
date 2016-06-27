<?php

use Illuminate\Database\Seeder;

class BuildingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        App\Building::create([
            'name' => 'Bananier',
            'time' => 0,
            'wood' => 0,
            'level' => 0,
            'type' => 'base',
        ]);

        App\Building::create([
            'name' => 'Caserne basique',
            'time' => 60*5,
            'wood' => 100,
            'level' => 0,
            'type' => 'barrack',
        ]);

        App\Building::create([
            'name' => 'Caserne avancé',
            'time' => 60*10,
            'wood' => 200,
            'level' => 1,
            'type' => 'barrack',
        ]);

        App\Building::create([
            'name' => 'Caserne expert',
            'time' => 60*20,
            'wood' => 400,
            'level' => 2,
            'type' => 'barrack',
        ]);

        App\Building::create([
            'name' => 'Laboratoire basique',
            'time' => 60*5,
            'wood' => 100,
            'level' => 0,
            'type' => 'laboratory',
        ]);

        App\Building::create([
            'name' => 'Laboratoire avancé',
            'time' => 60*10,
            'wood' => 200,
            'level' => 1,
            'type' => 'laboratory',
        ]);

        App\Building::create([
            'name' => 'Laboratoire scientifique',
            'time' => 60*20,
            'wood' => 400,
            'level' => 2,
            'type' => 'laboratory',
        ]);
    }
}
