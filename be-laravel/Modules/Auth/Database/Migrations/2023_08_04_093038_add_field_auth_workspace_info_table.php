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
        Schema::table('auth_workspace_info', function (Blueprint $table) {
            $table->string('short_name')->after('name');
            $table->string('code')->after('short_name');
            $table->string('alias')->after('code');
            $table->unsignedInteger('created_by')->nullable()->after('custom_data');
            $table->unsignedInteger('updated_by')->nullable()->after('created_by');
            $table->unsignedInteger('deleted_by')->nullable()->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auth_workspace_info', function (Blueprint $table) {
            $table->dropColumn('short_name');
            $table->dropColumn('code');
            $table->dropColumn('alias');
        });
    }
};
