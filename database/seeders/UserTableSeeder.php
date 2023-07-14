<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();
        User::create([
            'role_id' => 1,
            'name' => 'Adminstrator',
            'email' => 'admin@mail.ru',
            'password' => Hash::make('qwerty')
        ]);
    }
}
