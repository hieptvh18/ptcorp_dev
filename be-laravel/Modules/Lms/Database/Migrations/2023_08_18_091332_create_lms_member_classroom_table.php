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
        Schema::create('lms_member_classroom', function (Blueprint $table) {
            $table->unsignedInteger('member_id');
            $table->unsignedInteger('classroom_id');
            $table->boolean('is_class_teacher_leader', false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lms_member_classroom');
    }
};
