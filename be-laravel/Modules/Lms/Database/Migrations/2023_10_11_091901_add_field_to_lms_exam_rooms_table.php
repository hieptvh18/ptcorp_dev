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
        Schema::table('lms_exam_rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id')->after('description');
            $table->enum('exam_type',['SPECIFIC','RANDOM'])->default('RANDOM')->after('subject_id');
            $table->unsignedBigInteger('exam_id')->after('exam_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lms_exam_rooms', function (Blueprint $table) {

        });
    }
};
