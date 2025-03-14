<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfirmacaoToEscalasTable extends Migration
{
    public function up()
    {
        Schema::table('escalas', function (Blueprint $table) {
            $table->boolean('confirmado_voluntario_1')->nullable()->after('voluntario_id_2');
            $table->text('motivo_ausencia_1')->nullable()->after('confirmado_voluntario_1');
            $table->boolean('confirmado_voluntario_2')->nullable()->after('motivo_ausencia_1');
            $table->text('motivo_ausencia_2')->nullable()->after('confirmado_voluntario_2');
        });
    }

    public function down()
    {
        Schema::table('escalas', function (Blueprint $table) {
            $table->dropColumn(['confirmado_voluntario_1', 'motivo_ausencia_1', 'confirmado_voluntario_2', 'motivo_ausencia_2']);
        });
    }
}