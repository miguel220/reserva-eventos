<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsibleToEventosTable extends Migration
{
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->string('responsible')->nullable()->after('promo_end_date'); // Responsável do evento
        });
    }

    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('responsible');
        });
    }
}