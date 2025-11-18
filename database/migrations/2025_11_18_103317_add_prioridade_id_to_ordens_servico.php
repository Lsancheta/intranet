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
        Schema::table('ordens_servico', function (Blueprint $table) {
            $table->unsignedBigInteger('prioridade_id')->nullable()->after('status_id');
            $table->foreign('prioridade_id')->references('id')->on('prioridades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordens_servico', function (Blueprint $table) {
            //
        });
    }
};
