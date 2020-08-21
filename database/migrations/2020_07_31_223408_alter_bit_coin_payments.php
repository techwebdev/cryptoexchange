<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBitCoinPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bitcoin_payments', function (Blueprint $table) {
            $table->enum('status',['0','1','2'])->comment('0 - Pending,1 - Success, 2 - Reject')->default(0)->after('fees');
            $table->softDeletes()->after('updated_at');
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
