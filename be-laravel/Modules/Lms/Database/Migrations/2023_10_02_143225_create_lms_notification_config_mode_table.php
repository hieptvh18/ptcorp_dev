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
        Schema::create('lms_notification_config_mode', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_config_id');
            $table->string('notification_typeable');
            $table->unsignedBigInteger('notification_typeable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lms_notification_config_mode');
    }
};
