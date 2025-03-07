<?php

namespace Database\Seeders;

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
        $user = \App\Models\User::create([
            'name'     => 'admin',
            'username' => 'admin',
            'email'    => 'super_admin@app.com',
            'password' => bcrypt('123123123'),
        ]);

        $user->attachRole('super_admin');

    }//end of run
    
}//end of class
