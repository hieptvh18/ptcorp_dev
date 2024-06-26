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
        Schema::create('lms_events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('subject_ids');
            $table->string('classroom_ids');
            $table->string('member_ids');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('type', ['ALL', 'MEMBER', 'CLASSROOM', 'CLASSROOM_SUBJECT', 'SUBJECT', 'CUSTOM'])->default('ALL');
            $table->enum('status', ['DRAFT', 'PUBLISH', 'ARCHIVE'])->default('PUBLISH');
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
        Schema::dropIfExists('lms_events');
    }
};
