<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'negar',
                'email' => 'negar@site.com',
                'password' => '1234'
            ]
        ];
        foreach ($users as $user){
            User::create($user);
        }
    }
}
