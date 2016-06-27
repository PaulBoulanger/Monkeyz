<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'Niir',
            'email' => 'sebdesquirez@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('passpass'),
        ])->buildings()->attach(['1']);

        App\User::create([
            'name' => 'Monkey',
            'email' => 'monkey@sebdsz.fr',
            'password' => \Illuminate\Support\Facades\Hash::make('passpass'),
        ])->buildings()->attach(['1']);

    }
}
