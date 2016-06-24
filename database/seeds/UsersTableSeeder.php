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
            'name' => 'Desquirez Sébastien',
            'email' => 'sebdesquirez@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('passpass'),
        ]);

        factory(App\User::class, 50)->create();
    }
}
