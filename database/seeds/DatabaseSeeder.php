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
        $this->call(BuildingsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BasesTableSeeder::class);
        $this->call(FieldsTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(UnitNameTableSeeder::class);
        $this->call(TechnologiesTableSeeder::class);
    }
}
