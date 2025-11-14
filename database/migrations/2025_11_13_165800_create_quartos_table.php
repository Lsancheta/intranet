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
        Schema::create('quartos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bloco_id')->constrained('blocos')->cascadeOnDelete();
            $table->string('numero');
            $table->integer('capacidade')->default(0);
            $table->integer('ocupacao_atual')->default(0);
            $table->string('status')->default('livre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quartos');
    }
};
