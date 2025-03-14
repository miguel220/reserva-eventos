<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveVoluntariosFromEscalasTable extends Migration
{
    public function up()
    {
        Schema::table('escalas', function (Blueprint $table) {
            $table->dropForeign(['voluntario_id_1']);
            $table->dropForeign(['voluntario_id_2']);
            $table->dropColumn([
                'voluntario_id_1',
                'voluntario_id_2',
                'confirmado_voluntario_1',
                'motivo_ausencia_1',
                'confirmado_voluntario_2',
                'motivo_ausencia_2',
            ]);
        });
    }

    public function down()
    {
        Schema::table('escalas', function (Blueprint $table) {
            $table->unsignedBigInteger('voluntario_id_1')->nullable()->after('setor_id');
            $table->unsignedBigInteger('voluntario_id_2')->nullable()->after('voluntario_id_1');
            $table->boolean('confirmado_voluntario_1')->nullable()->after('voluntario_id_2');
            $table->text('motivo_ausencia_1')->nullable()->after('confirmado_voluntario_1');
            $table->boolean('confirmado_voluntario_2')->nullable()->after('motivo_ausencia_1');
            $table->text('motivo_ausencia_2')->nullable()->after('confirmado_voluntario_2');

            $table->foreign('voluntario_id_1')->references('id')->on('users')->onDelete('set null');
            $table->foreign('voluntario_id_2')->references('id')->on('users')->onDelete('set null');
        });
    }
}