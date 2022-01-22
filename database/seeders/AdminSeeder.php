<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'first_name' => 'Christoph',
            'last_name' => 'Swoboda',
            'gender' => 'male',
            'email' => 'alex@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 1,
            'email_verified_at' => now()
        ];
        User::create($user);
    }
}
