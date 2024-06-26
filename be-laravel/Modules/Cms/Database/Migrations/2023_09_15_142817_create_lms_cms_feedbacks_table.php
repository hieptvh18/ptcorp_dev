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
        Schema::create('lms_cms_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // title feedback
            $table->text('description');
            $table->string('student_name');
            $table->string('student_avatar_url')->nullable();
            $table->enum('type',['COURSE'])->default('COURSE');
            $table->boolean('is_show_homepage',true);
            $table->integer('sort_order')->nullable();
            $table->boolean('is_active',true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('lms_cms_feedbacks');
    }
};
