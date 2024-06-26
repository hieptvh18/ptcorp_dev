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
        Schema::table('lms_cms_student_contacts', function (Blueprint $table) {
            $table->enum('type', ['GENERAL', 'STUDENT'])->default('GENERAL')->after('user_agent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lms_cms_student_contacts', function (Blueprint $table) {
            $table->dropColumn(['type']);
        });
    }
};
