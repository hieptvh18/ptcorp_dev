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
            $table->decimal('regular_price',12,2)->change();
            $table->decimal('sale_price',12,2)->nullable()->default(0)->change();
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
//            $table->float('regular_price');
//            $table->float('sale_price')->nullable()->default(0);
        });
    }
};
