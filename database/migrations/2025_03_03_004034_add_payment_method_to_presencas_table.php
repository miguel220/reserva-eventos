<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentMethodToPresencasTable extends Migration
{
    public function up()
    {
        Schema::table('presencas', function (Blueprint $table) {
            $table->enum('payment_method', ['church', 'online'])->nullable()->after('confirmado'); // Método de pagamento
            $table->string('payment_status')->nullable()->after('payment_method'); // Status do pagamento (ex.: pendente, pago)
            $table->string('transaction_id')->nullable()->after('payment_status'); // ID da transação, se online
        });
    }

    public function down()
    {
        Schema::table('presencas', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'transaction_id']);
        });
    }
}