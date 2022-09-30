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
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('project_id')->constrained()->restrictOnDelete();
            $table->string('on_behalf');
            $table->boolean('is_anonim');

            $table->bigInteger('given_amount');
            $table->bigInteger('maintenance_fee');
            $table->bigInteger('payment_fee');
            $table->bigInteger('total_amount');
            $table->string('merchant_code');
            $table->string('merchant_order_id');
            $table->string('reference');
            $table->string('payment_method');
            $table->string('payment_name');
            $table->string('payment_image_url');
            $table->string('payment_url');

            $table->string('va_number')->nullable();
            $table->string('qr_string')->nullable();
            $table->string('expiry_period');

            $table->string('callback_url');
            $table->string('return_url');
            $table->string('signature');
            $table->string('product_details');

            $table->string('status_code')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_at')->nullable();


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
