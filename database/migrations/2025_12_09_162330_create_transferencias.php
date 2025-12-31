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
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alojamento_id')->constrained('alojamentos')->cascadeOnDelete();
            $table->foreignId('produto_id')->constrained('produtos');
            $table->foreignId('local_origem_id')->nullable()->constrained('locais');
            $table->foreignId('local_destino_id')->nullable()->constrained('locais');
            $table->foreignId('tipo_id')->constrained('tipos_transferencia');
            
            $table->decimal('quantidade', 8, 3);
            $table->string('observacao')->nullable();
            $table->foreignId('usuario_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferencias');
    }
};
