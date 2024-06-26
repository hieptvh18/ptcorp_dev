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
        Schema::table('lms_cms_blogs', function (Blueprint $table) {
            DB::statement("ALTER TABLE lms_cms_blogs MODIFY type ENUM('EDUQUIZ', 'CRM', 'EDUCMS') DEFAULT 'CRM'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
