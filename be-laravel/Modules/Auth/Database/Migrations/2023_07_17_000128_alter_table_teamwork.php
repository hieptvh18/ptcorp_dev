<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Config::get('teamwork.teams_table'), function (Blueprint $table) {
            $table->integer('teamable_id')->nullable();
            $table->string('teamable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Config::get('teamwork.teams_table'), function (Blueprint $table) {
            $table->dropColumn('teamable_id');
            $table->dropColumn('teamable_type');
        });
    }
};
