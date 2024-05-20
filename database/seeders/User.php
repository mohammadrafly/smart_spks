<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User as ModelUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'photo' => '',
                'phone' => '02100000',
                'usertype' => 'admin',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Guru',
                'email' => 'guru@gmail.com',
                'password' => Hash::make('guru'),
                'photo' => '',
                'phone' => '02100000',
                'usertype' => 'bk/guru',
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];

        ModelUser::insert($users);
    }
}
