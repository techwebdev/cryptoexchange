<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterbitcoinUnspentStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bitcoin_payments', function (Blueprint $table) {
            $table->enum("unspent_status",["0","1"])->comment("0 - not confirm 1 - confirm")->default(0)->after("status");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bitcoin_payments', function (Blueprint $table) {
            //
        });
    }
}
