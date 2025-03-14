<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscalaUserTable extends Migration
{
    public function up()
    {
        Schema::create('escala_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('escala_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('confirmado')->nullable();
            $table->text('motivo_ausencia')->nullable();
            $table->timestamps();

            $table->foreign('escala_id')->references('id')->on('escalas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Garantir que um voluntário não seja atribuído mais de uma vez à mesma escala
            $table->unique(['escala_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('escala_user');
    }
}