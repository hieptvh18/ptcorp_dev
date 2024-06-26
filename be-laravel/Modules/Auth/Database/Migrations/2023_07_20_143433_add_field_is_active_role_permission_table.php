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
        Schema::table('auth_roles', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('bizapp_alias');
        });

        Schema::table('auth_permissions', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('bizapp_alias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auth_roles', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('auth_permissions', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
