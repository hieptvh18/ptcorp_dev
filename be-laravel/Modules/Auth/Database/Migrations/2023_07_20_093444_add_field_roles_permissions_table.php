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
            $table->string('bizapp_alias')->after('label');
        });

        Schema::table('auth_permissions', function (Blueprint $table) {
            $table->integer('parent_id')->default(0)->after('label');
            $table->string('bizapp_alias')->after('parent_id');
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
            $table->dropColumn('bizapp_alias');
        });

        Schema::table('auth_roles', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('bizapp_alias');
        });
    }
};
