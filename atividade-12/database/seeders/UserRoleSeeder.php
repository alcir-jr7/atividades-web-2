<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(2)->create([
            'role' => 'admin',
            'password' => bcrypt('12345678'),
        ]);


        User::factory(2)->create([
            'role' => 'bibliotecario',
            'password' => bcrypt('12345678'),
        ]);
    }
}
