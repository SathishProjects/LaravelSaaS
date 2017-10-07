<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => str_random(10),
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('admin123'),
            'mysql_database' => 'tenant',
            'mysql_username' => 'root',
            'mysql_password' => 'welcome@123',
        ]);
    }
}
