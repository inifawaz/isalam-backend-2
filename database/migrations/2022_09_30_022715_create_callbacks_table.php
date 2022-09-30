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
        Schema::create('callbacks', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_code')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->string('merchant_order_id')->nullable();
            $table->string('product_detail')->nullable();
            $table->string('additional_param')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('result_code', 2)->nullable();
            $table->string('merchant_user_id')->nullable();
            $table->string('reference')->nullable();
            $table->string('signature')->nullable();
            $table->string('sp_user_hash')->nullable();
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
        Schema::dropIfExists('callbacks');
    }
};
