<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 5; $i++){
            User::create([
                'name' => 'User'.$i,
                'email' => 'user'.$i.'@email.com',
                'role' => 5,
                'password' => bcrypt('00000000'),
            ]);
        }
    }
}
