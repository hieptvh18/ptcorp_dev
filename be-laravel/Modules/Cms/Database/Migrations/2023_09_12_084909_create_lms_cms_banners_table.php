<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_cms_banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['VIDEO', 'IMAGE'])->default('IMAGE');
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->enum('position', ['HOMEPAGE_COURSE'])->default('HOMEPAGE_COURSE');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->boolean('is_active', true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lms_cms_banners');
    }
};
