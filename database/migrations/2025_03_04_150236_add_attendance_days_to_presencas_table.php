<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttendanceDaysToPresencasTable extends Migration
{
    public function up()
    {
        Schema::table('presencas', function (Blueprint $table) {
            $table->json('attendance_days')->nullable()->after('attendance_status');
        });
    }

    public function down()
    {
        Schema::table('presencas', function (Blueprint $table) {
            $table->dropColumn('attendance_days');
        });
    }
}