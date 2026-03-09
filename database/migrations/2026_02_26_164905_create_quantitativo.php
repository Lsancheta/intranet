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
        Schema::create('quantitativo', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('fazenda');
            $table->string('nome');
            $table->integer('quantidade');
            $table->foreignId('alojamento_id')
                    ->nullable()
                    ->constrained('alojamentos')
                    ->nullOnDelete();
            $table->foreignId('bloco_id')
                    ->nullable()
                    ->constrained('blocos')
                    ->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantitativo');
    }
};
