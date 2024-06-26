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
        Schema::create('notification_email_logs', function (Blueprint $table) {
            $table->uuid('id');
            $table->enum('status', ['PENDING', 'FAILED', 'SENT'])->default('PENDING');
            $table->string('subject');
            $table->string('recipient');
            $table->string('sender');
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->longText('variables');
            $table->bigInteger('template_id');
            $table->json('template_forzen');
            $table->text('error')->nullable();
            $table->string('bizapp_alias')->nullable();
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
        Schema::dropIfExists('notification_email_logs');
    }
};
