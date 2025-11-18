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
        DB::table('prioridades')
            ->where('nome', 'M')
            ->update(['nome' => 'Media']);
    }

    public function down()
    {
        DB::table('prioridades')
            ->where('nome', 'Media')
            ->update(['nome' => 'M']);
    }
};
