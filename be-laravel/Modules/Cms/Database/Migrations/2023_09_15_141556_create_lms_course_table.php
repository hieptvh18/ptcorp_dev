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
        Schema::create('lms_course', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->string('code');
            $table->string('short_description')->nullable();
            $table->float('regular_price'); // gia goc
            $table->float('sale_price')->nullable()->default(0); // gia ban
            $table->string('preview_video_url');
            $table->integer('total_duration')->nullable()->default(0);
            $table->enum('type',['ONLINE','OFFLINE'])->default('OFFLINE');
            $table->string('address')->nullable(); // dia chi hoc
            $table->enum('status',['DRAFT','PUBLISH','UNPUBLISH','PRIVATE'])->default('PUBLISH');
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
        Schema::dropIfExists('lms_course');
    }
};
