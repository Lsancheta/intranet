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
        Schema::create('transferencia_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transferencia_id')->constrained('transferencias')->cascadeOnDelete();
            $table->foreignId('produto_id')->constrained('produtos');
            $table->decimal('quantidade',10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferencia_itens');
    }
};
