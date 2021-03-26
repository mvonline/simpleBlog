<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678')
        ]);
        $admin->assignRole('admin');

        $manager = User::create([
            'name' => 'manager',
            'email' => 'manager@admin.com',
            'password' => bcrypt('12345678')
        ]);
        $manager->assignRole('manager');

        $user = User::create([
            'name' => 'user',
            'email' => 'user@admin.com',
            'password' => bcrypt('12345678')
        ]);
        $user->assignRole('user');
    }
}
