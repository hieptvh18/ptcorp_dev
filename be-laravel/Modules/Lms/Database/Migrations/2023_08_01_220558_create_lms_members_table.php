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
        Schema::create('lms_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->dateTime('birth_day')->nullable();
            $table->string('mobile');
            $table->string('email');
            $table->enum('type', ['TEACHER', 'STUDENT'])->default('STUDENT');
            $table->text('custom_data')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('lms_members');
    }
};
