<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEventosTableAddDataInicioEFim extends Migration
{
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('data'); // Remove o campo data antigo
            $table->dateTime('data_inicio'); // Adiciona data de início
            $table->dateTime('data_fim'); // Adiciona data de fim
        });
    }

    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn(['data_inicio', 'data_fim']);
            $table->dateTime('data'); // Restaura o campo data no rollback
        });
    }
}