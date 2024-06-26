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
        Schema::create('auth_workspace_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('teamwork_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('background_image_url')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->dateTime('founded_date')->nullable();
            $table->json('custom_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_workspace_info');
    }
};
