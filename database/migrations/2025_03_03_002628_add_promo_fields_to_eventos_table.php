<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromoFieldsToEventosTable extends Migration
{
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->decimal('promo_price', 8, 2)->nullable()->after('price'); // Valor promocional
            $table->dateTime('promo_start_date')->nullable()->after('promo_price'); // Data de início da promoção
            $table->dateTime('promo_end_date')->nullable()->after('promo_start_date'); // Data de fim da promoção
        });
    }

    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn(['promo_price', 'promo_start_date', 'promo_end_date']);
        });
    }
}