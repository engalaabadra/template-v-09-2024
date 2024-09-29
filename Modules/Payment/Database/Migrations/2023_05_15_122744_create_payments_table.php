<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->nullOnDelete();
            $table->morphs('paymentable');
            $table->morphs('payer');
            $table->float('amount');
            $table->string('currency_code');
            $table->tinyInteger('type')->default(1);//1: payment , -1: refund
            $table->tinyInteger('status')->default(0);//0: pending , 1: success , -1 : faild
            $table->string('transaction_id')->nullable();
            $table->string('payment_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
