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
        DB::statement("ALTER TABLE auth_user_info MODIFY type ENUM('ADMIN', 'TEACHER', 'STUDENT', 'SV_HUBT', 'OTHER') DEFAULT 'STUDENT'");
        Schema::table('auth_user_info', function (Blueprint $table) {
            $table->json('custom_data')->nullable()->after('type');
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
