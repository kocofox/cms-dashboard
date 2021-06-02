<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class WebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('webs')->insert([
        	[
	        	'titulo'=> 'ESB',
        'descripcion'=> 'ESB produccion',
        'etiquetas'=> '',
        'logo'=> '',
        'favicon'=> '',
        'redes'=> '{}',
        'nosotros'=> 'ESB',
        'mision'=> 'ESB',
        'vision'=> 'ESB',
        'footer' => '{}',
	        	
        	]
        	
        ]);
    }
}
