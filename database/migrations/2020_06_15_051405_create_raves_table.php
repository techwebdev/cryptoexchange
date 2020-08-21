<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raves', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('txn_id');
            $table->text('txn_Ref');
            $table->text('txn_flwRef')->nullable();
            $table->string('currency');
            $table->string('amount');
            $table->text('charges');
            $table->enum('txn_status',['0','1'])->comment('0 - Pending,1 - Success, 2 - Reject')->default(0);
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
        Schema::dropIfExists('raves');
    }
}
