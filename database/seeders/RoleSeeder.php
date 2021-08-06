<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'nombre' => 'admin',
                'descripcion' => 'administrador ESB produccion',
                'tipo' => '',
            ],
            [
                'nombre' => 'colaborador',
                'descripcion' => 'colaborador ESB produccion',
                'tipo' => '',
            ],
            [
                'nombre' => 'editor',
                'descripcion' => 'colaborador ESB ',
                'tipo' => '',
            ],
            [
                'nombre' => 'usuario',
                'descripcion' => 'colaborador ESB ',
                'tipo' => '',
            ]

        ]);
    }
}
