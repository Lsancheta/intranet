<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ordens_servico', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->default(1); // 1 = Aberta
            $table->foreign('status_id')->references('id')->on('status_os');
        });
    }

    public function down()
    {
        Schema::table('ordens_servico', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
};
