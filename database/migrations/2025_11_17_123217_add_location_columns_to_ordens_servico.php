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
        Schema::table('ordens_servico', function (Blueprint $table) {
            $table->foreignId('alojamento_id')->nullable()->constrained('alojamentos') ->nullOnDelete();
            $table->foreignId('bloco_id')->nullable()->constrained('blocos')->nullOnDelete();
            $table->foreignId('quarto_id')->nullable()->constrained('quartos')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordens_servico', function (Blueprint $table) {
            $table->dropForeign(['alojamento_id']);
            $table->dropForeign(['bloco_id']);
            $table->dropForeign(['quarto_id']);
            $table->dropColumn(['alojamento_id', 'bloco_id', 'quarto_id']);
        });
    }
};
