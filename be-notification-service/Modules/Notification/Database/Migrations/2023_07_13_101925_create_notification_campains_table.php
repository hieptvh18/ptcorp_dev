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
        Schema::create('notification_campains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->longText('content');
            $table->enum('status', ['DRAFT', 'PUBLISH', 'ARCHIVE'])->default('DRAFT');
            $table->dateTime('published_at');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('notification_campains');
    }
};
