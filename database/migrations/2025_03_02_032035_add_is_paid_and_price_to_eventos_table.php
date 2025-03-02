<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPaidAndPriceToEventosTable extends Migration
{
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->boolean('is_paid')->default(false)->after('token'); // Indica se o evento é pago
            $table->decimal('price', 8, 2)->nullable()->after('is_paid'); // Valor do evento, se pago
        });
    }

    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn(['is_paid', 'price']);
        });
    }
}