<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locais')->insert([
            ['id' => 1, 'nome' => 'Deposito Colombia', 'tipo' => 'deposito', 'alojamento_id' => 1],
            ['id' => 2, 'nome' => 'Estoque Colombia', 'tipo' => 'estoque', 'alojamento_id' => 1],
            ['id' => 3, 'nome' => 'Deposito Laranjeiras', 'tipo' => 'deposito', 'alojamento_id' => 2],
            ['id' => 4, 'nome' => 'Estoque Laranjeiras', 'tipo' => 'estoque', 'alojamento_id' => 2],
        ]);
    }
}
