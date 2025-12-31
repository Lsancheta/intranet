<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoMovimentacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_transferencia')->insert([
            ['id'=> 1, 'nome' => 'Entrada'],
            ['id'=> 2, 'nome' => 'Saida'],
            ['id'=> 3, 'nome' => 'Transferencia'],
            ['id'=> 4, 'nome' => 'Ajuste'],
        ]);
    }
}
