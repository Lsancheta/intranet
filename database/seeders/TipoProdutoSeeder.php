<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_produtos')->insert([
            ['nome' => 'Nao Perecivel', 'created_at' => now(), 'updated_at' => now(), 'precisa_transferencia' => true],
            ['nome' => 'Proteina', 'created_at' => now(), 'updated_at' => now(), 'precisa_transferencia' => false],
            ['nome' => 'Hortifruti', 'created_at' => now(), 'updated_at' => now(), 'precisa_transferencia' => false],
            ['nome' => 'Material de Limpeza', 'created_at' => now(), 'updated_at' => now(), 'precisa_transferencia' => false],
            ['nome' => 'Equipamento', 'created_at' => now(), 'updated_at' => now(),'precisa_transferencia' => false],
            ['nome' => 'Insumo', 'created_at' => now(), 'updated_at' => now(), 'precisa_transferencia' => false],
        ]);
    }
}
