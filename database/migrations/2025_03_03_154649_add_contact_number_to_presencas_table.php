<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactNumberToPresencasTable extends Migration
{
    public function up()
    {
        Schema::table('presencas', function (Blueprint $table) {
            $table->string('contact_number')->nullable()->after('email'); // Número de contato
        });
    }

    public function down()
    {
        Schema::table('presencas', function (Blueprint $table) {
            $table->dropColumn('contact_number');
        });
    }
}