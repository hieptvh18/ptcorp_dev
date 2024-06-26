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
        Schema::table('lms_course', function (Blueprint $table) {
            $table->text('description')->after('short_description')->nullable();
            $table->text('avatar_url')->after('sale_price');
            $table->enum('preview_video_type', ['VIDEO', 'YOUTUBE'])->nullable()->default('YOUTUBE')->after('preview_video_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lms_course', function (Blueprint $table) {
            $table->dropColumn(['avatar_url', 'description','preview_video_type']);
        });
    }
};
