<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $novos_blocos = [
            'Externa',
            'Estacionamento',
            'Estacionamento Ônibus',
            'Portaria',
            'Reunião',
            'Escritório',
            'Vivência',
            'Cozinha',
            'Refeitório',
            'Depósitos',
            'Lavanderia',
            'Reservatório Poço 1',
            'Reservatório Poço 2',
            'Estação Elevatória',
            'Campo de Futebol 1',
            'Central de Gás',
        ];

        foreach ($novos_blocos as $bloco) {
            DB::table('blocos')->insert([
                ['nome' => $bloco, 'alojamento_id' => 1],
                ['nome' => $bloco, 'alojamento_id' => 2],
            ]);
        }
    }

    public function down()
    {
        $novos_blocos = [
            'Externa',
            'Estacionamento',
            'Estacionamento Ônibus',
            'Portaria',
            'Reunião',
            'Escritório',
            'Vivência',
            'Cozinha',
            'Refeitório',
            'Depósitos',
            'Lavanderia',
            'Reservatório Poço 1',
            'Reservatório Poço 2',
            'Estação Elevatória',
            'Campo de Futebol 1',
            'Central de Gás',
        ];

        DB::table('blocos')
            ->whereIn('nome', $novos_blocos)
            ->delete();
    }
};
