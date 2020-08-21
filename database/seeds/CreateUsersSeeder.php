<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@gmail.com',
               'email_verified_at' => date('Y-m-d h:i:s'),
               'is_admin'=>'1',
               'isVerified' => '1',
               'password'=> bcrypt('123456'),
               'mobile' => '7878787878'
            ],
            [
               'name'=>'User',
               'email'=>'user@gmail.com',
               'email_verified_at' => date('Y-m-d h:i:s'),
               'is_admin'=>'0',
               'isVerified' => '1',
               'password'=> bcrypt('123456'),
               'mobile' => '7878787878'
            ],
        ];
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
