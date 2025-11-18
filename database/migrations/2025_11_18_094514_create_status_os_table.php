<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_os', function (Blueprint $table) {
            $table->id();
            $table->string('nome');          // Aberta, Em andamento, etc
            $table->string('cor')->nullable();  // Ex: bg-blue-200
            $table->integer('ordem')->default(1); // Para ordenar prioridades
            $table->timestamps();
        });

        // Insere os status iniciais
        \DB::table('status_os')->insert([
            ['nome' => 'Aberta', 'cor' => 'bg-blue-200', 'ordem' => 1],
            ['nome' => 'Em andamento', 'cor' => 'bg-yellow-200', 'ordem' => 2],
            ['nome' => 'Pendente', 'cor' => 'bg-red-200', 'ordem' => 3],
            ['nome' => 'Resolvida', 'cor' => 'bg-green-200', 'ordem' => 4],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('status_os');
    }
};

