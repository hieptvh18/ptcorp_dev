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
        Schema::table('lms_classrooms', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('lms_classrooms', function (Blueprint $table) {
            $table->enum('type', ['CLASS', 'GROUP'])->default('CLASS')->after('is_active');
            $table->enum('status', ['PUBLISH', 'PRIVATE', 'CUSTOM'])->default('PUBLISH')->after('type');
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
