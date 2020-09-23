<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'admin', 
            'email' => 'admin@gce.com', 
            'is_admin' => true, 
            'password' => \Hash::make('12345678'),
            'created_at' => date('Y-m-d H:i:s', (time())),
            'updated_at' => date('Y-m-d H:i:s', (time()))]
        ]);    
    }
}
