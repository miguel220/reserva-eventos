<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEventosTableRemoveDates extends Migration
{
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn(['data_inicio', 'data_fim']);
        });
    }

    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim');
        });
    }
}