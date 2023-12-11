<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'first_name' => 'Admin',
                'last_name'=>'Admin',
                'salary'=>99999,
                'img' => 'test',
                'is_admin'=>1,
                'email' => 'admin@admin.com',
                'password' => bcrypt('1234')
            ]
        ];
    
        foreach ($user as $userData) {
            User::create($userData);
        }
    }
}
