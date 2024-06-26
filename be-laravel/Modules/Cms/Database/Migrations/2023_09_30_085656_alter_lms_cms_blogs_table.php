<?php

use Illuminate\Support\Facades\DB;
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
        DB::statement("ALTER TABLE lms_cms_blogs MODIFY type ENUM('STATIC', 'NORMAL') DEFAULT 'NORMAL'");
        DB::statement("ALTER TABLE lms_cms_blogs MODIFY bizapp ENUM('EDUQUIZ', 'CRM', 'EDUCMS', 'EDULMS') DEFAULT 'EDUCMS'");
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
