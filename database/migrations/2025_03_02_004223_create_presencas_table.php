<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencasTable extends Migration
{
    public function up()
    {
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained()->onDelete('cascade');
            $table->string('nome'); // Nome da pessoa que confirma presença
            $table->string('email')->unique(); // Email único para evitar duplicatas
            $table->boolean('confirmado')->default(false); // Status da confirmação
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('presencas');
    }
}