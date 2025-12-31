<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transferencias', function (Blueprint $table) {
            // Adicionando status_id com o valor default para 'Aberta' (id 1)
            $table->unsignedBigInteger('status_id')->default(1); // 1 = Aberta

            // Definindo a chave estrangeira
            $table->foreign('status_id')
                  ->references('id')->on('status_os')
                  ->onDelete('set null');  // Ou 'cascade' se preferir excluir as transferências relacionadas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transferencias', function (Blueprint $table) {
            // Removendo a chave estrangeira e a coluna
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
};
