<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class produtoTransferencia extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_produtos')->insert([
            ['nome' => 'Proteina', 'precisa_transferencia'=> false],
            ['nome' => 'Hortifruti', 'precisa_transferencia'=> false],
        ]);
    }
}
