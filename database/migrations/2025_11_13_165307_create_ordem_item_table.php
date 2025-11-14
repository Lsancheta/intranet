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
        Schema::create('ordem_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordem_id')->constrained('ordens_servico')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('itens_estoque')->cascadeOnDelete();
            $table->integer('quantidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordem_item');
    }
};
