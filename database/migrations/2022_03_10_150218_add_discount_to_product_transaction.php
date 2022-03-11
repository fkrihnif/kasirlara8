<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToProductTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_transaction', function (Blueprint $table) {
            $table->string('disc_rp')->nullable();
            $table->string('disc_prc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_transaction', function (Blueprint $table) {
            $table->dropColumn('disc_rp');
            $table->dropColumn('disc_prc');
        });
    }
}
