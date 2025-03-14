<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEquipeIdToPresencasTable extends Migration
{
    public function up()
    {
        Schema::table('presencas', function (Blueprint $table) {
            $table->foreignId('equipe_id')->nullable()->after('evento_id')->constrained()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('presencas', function (Blueprint $table) {
            $table->dropForeign(['equipe_id']);
            $table->dropColumn('equipe_id');
        });
    }
}