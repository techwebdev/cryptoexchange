<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('type_id')->unsigned(); 
            $table->foreign('type_id')->references('id')->on('type')->onDelete('cascade');
            $table->bigInteger('transaction_id')->unsigned(); 
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->string('draccount');
            $table->string('craccount');
            $table->string('ref_no');
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
