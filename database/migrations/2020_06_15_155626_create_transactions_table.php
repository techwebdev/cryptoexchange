<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('rave_id')->unsigned(); 
            $table->foreign('rave_id')->references('id')->on('raves')->onDelete('cascade');
            $table->string('amount');
            $table->string('transferAmount');
            $table->string('charges');
            $table->string('from_currency',50);
            $table->string('to_currency',50);
            $table->enum('status',['0','1','2'])->comment('0 - Pending,1 - Success, 2 - Reject')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
