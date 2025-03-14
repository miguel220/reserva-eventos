<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSetorIdAndIsProducerToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('setor_id')->nullable()->after('is_seeder');
            $table->foreign('setor_id')->references('id')->on('setores')->onDelete('set null');
            $table->boolean('is_producer')->default(false)->after('setor_id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['setor_id']);
            $table->dropColumn(['setor_id', 'is_producer']);
        });
    }
}