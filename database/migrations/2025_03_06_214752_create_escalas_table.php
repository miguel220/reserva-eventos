<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscalasTable extends Migration
{
    public function up()
    {
        Schema::create('escalas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evento_id');
            $table->date('data');
            $table->unsignedBigInteger('setor_id');
            $table->unsignedBigInteger('voluntario_id_1')->nullable();
            $table->unsignedBigInteger('voluntario_id_2')->nullable();
            $table->timestamps();

            // Definir chaves estrangeiras explicitamente
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            $table->foreign('setor_id')->references('id')->on('setores')->onDelete('cascade');
            $table->foreign('voluntario_id_1')->references('id')->on('users')->onDelete('set null');
            $table->foreign('voluntario_id_2')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('escalas');
    }
}