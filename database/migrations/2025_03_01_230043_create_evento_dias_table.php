<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventoDiasTable extends Migration
{
    public function up()
    {
        Schema::create('evento_dias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained()->onDelete('cascade'); // Relaciona ao evento
            $table->date('data'); // Data do dia
            $table->time('hora_inicio'); // Hora de início do dia
            $table->time('hora_fim'); // Hora de fim do dia
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evento_dias');
    }
}