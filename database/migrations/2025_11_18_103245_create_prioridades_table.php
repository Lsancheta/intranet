<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('prioridades', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Baixa, Média, Alta, Urgente
            $table->string('cor')->nullable(); // opcional - para estilizar no front
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prioridades');
    }
};
