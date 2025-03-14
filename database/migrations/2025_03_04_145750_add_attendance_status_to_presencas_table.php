<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttendanceStatusToPresencasTable extends Migration
{
    public function up()
    {
        Schema::table('presencas', function (Blueprint $table) {
            $table->enum('attendance_status', ['absent', 'present'])->nullable()->after('payment_status'); // Status de presença: ausente ou presente
        });
    }

    public function down()
    {
        Schema::table('presencas', function (Blueprint $table) {
            $table->dropColumn('attendance_status');
        });
    }
}