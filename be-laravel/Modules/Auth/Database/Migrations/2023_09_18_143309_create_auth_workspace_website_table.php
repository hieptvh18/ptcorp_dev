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
        Schema::create('auth_workspace_website', function (Blueprint $table) {
            $table->id();
            $table->string('workspace_alias');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slogan')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('favicon')->nullable();
            $table->string('email');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('auth_workspace_website');
    }
};
