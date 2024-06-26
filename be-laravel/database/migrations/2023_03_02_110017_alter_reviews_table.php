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
        Schema::dropIfExists('core_reviews');
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rating');
            $table->integer('customer_service_rating')->nullable();
            $table->integer('quality_rating')->nullable();
            $table->integer('friendly_rating')->nullable();
            $table->integer('pricing_rating')->nullable();
            $table->enum('recommend', ['Yes', 'No']);
            $table->enum('department', ['Sales', 'Service', 'Parts']);
            $table->string('title');
            $table->string('body');
            $table->boolean('approved')->default(0);
            $table->morphs('reviewable');
            $table->morphs('author');
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
        //
    }
};
