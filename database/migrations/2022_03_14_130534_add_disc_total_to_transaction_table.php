<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscTotalToTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction', function (Blueprint $table) {
            $table->string('account_number')->nullable();
            $table->string('disc_total_rp')->nullable();
            $table->string('disc_total_prc')->nullable();
            $table->string('method'); //offline dan online
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction', function (Blueprint $table) {
            $table->dropColumn('account_number');
            $table->dropColumn('disc_total_rp');
            $table->dropColumn('disc_total_prc');
            $table->dropColumn('method');
        });
    }
}
