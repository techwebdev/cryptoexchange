<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type', function (Blueprint $table) {
            $table->id();
            // $table->foreign('id')->references('type_id')->on('type')->onDelete('cascade');
            $table->string('name',50);
            $table->string('short_name',50);
            $table->timestamps();
        });
        Artisan::call( 'db:seed', [
            '--class' => 'CurrencyTypeSeeder',
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
        Schema::dropIfExists('type');
    }
}
