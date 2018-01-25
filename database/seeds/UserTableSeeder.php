<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\CodeProject\Entities\User::truncate();
        factory(\CodeProject\Entities\User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('secret'),
        ]);
        
        factory(\CodeProject\Entities\User::class, 10)->create();
    }
}
