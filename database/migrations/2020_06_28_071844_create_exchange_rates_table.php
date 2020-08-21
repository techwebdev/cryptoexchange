<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('from_currency',50);
            $table->string('to_currency',50);
            $table->string('amount',100);
            $table->timestamps();
            $table->softDeletes();
        });
        /*Artisan::call( 'db:seed', [
            '--class' => 'ExchangeRateSeeder',
            '--force' => true 
        ]);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_rates');
    }
}
