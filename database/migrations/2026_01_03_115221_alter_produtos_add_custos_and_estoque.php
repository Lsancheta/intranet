<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // remove campo antigo
            $table->dropColumn('peso_unitario');

            // novos campos
            $table->decimal('preco_custo', 10, 2)->default(0)->after('unidade');
            $table->integer('estoque_minimo')->default(0)->after('preco_custo');
            $table->boolean('ativo')->default(true)->after('estoque_minimo');
        });
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // rollback seguro
            $table->decimal('peso_unitario', 8, 3)->nullable();

            $table->dropColumn([
                'preco_custo',
                'estoque_minimo',
                'ativo',
            ]);
        });
    }
};
