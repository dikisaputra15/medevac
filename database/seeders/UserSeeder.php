<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [
            [
               'name'=>'CCI',
               'username'=>'cci',
               'email'=>'cci@gmail.com',
               'password'=> hash::make('concord'),
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
