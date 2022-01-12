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
            'gender' => 'm',
            'email' => 'admin@meraner-morgen.it',
            'password' => bcrypt('mmtest!'),
            'role' => 1,
            'email_verified_at' => now()
        ];
        User::create($user);
    }
}
