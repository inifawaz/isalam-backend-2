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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->text('featured_image_url')->nullable();
            $table->string('name');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description');
            $table->string('location');

            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();

            $table->bigInteger('maintenance_fee')->default(0);

            $table->boolean('is_target');
            $table->bigInteger('target_amount')->default(0);
            $table->bigInteger('first_choice_given_amount')->default(0);
            $table->bigInteger('second_choice_given_amount')->default(0);
            $table->bigInteger('third_choice_given_amount')->default(0);
            $table->bigInteger('fourth_choice_given_amount')->default(0);

            $table->boolean('is_limited_time');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->boolean('is_shown')->default(true);
            $table->boolean('is_ended')->default(false);
            $table->boolean('is_favourite')->default(false);


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
        Schema::dropIfExists('projects');
    }
};
