<?php

use Illuminate\Database\Seeder;

class UnitNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Unit_name::create([
            'unit_id' => 1,
            'name' => 'Singe ouvrier',
        ]);

        App\Unit_name::create([
            'unit_id' => 2,
            'name' => 'Singe éclaireurs',
        ]);

        App\Unit_name::create([
            'unit_id' => 3,
            'name' => 'Singe chauve-souris',
        ]);

        App\Unit_name::create([
            'unit_id' => 4,
            'name' => 'Singe transporteur',
        ]);

        App\Unit_name::create([
            'unit_id' => 5,
            'name' => 'Guerrier singe',
        ]);

        App\Unit_name::create([
            'unit_id' => 6,
            'name' => 'Guerrier singe avec bouclier',
        ]);

        App\Unit_name::create([
            'unit_id' => 7,
            'name' => 'Guerrier singe en armure',
        ]);

        App\Unit_name::create([
            'unit_id' => 8,
            'name' => 'Maître singe',
        ]);

    }
}


