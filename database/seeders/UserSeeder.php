<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	[
	        	'name'=> 'ESB',
        'fullname'=> 'ESB produccion',
        'profiles_id'=> '',
        'avatar'=> '',
        'email'=> 'fox@demo.com',
        'password'=> '$2y$10$h54T8Lf05oaaDQTMINU8muTIP5K6JHPOsTOyeo3gLUOeRSecjscgu',
       
	        	
        	]
        	
        ]);
    }
}
