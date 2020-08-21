<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterExchangeRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->string('currency')->after('id')->nullable();
            $table->enum('buy',['0','1'])->after('amount')->nullable();
            $table->enum('sell',['0','1'])->after('buy')->nullable();
        });
        App\ExchangeRate::truncate();
        Artisan::call( 'db:seed', [
            '--class' => 'ExchangeRateSeeder',
            '--force' => true 
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            //
        });
    }
}
