<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$array = array(
    		['name'=>'NGN'],
     		['name'=>'PM'],
     		['name'=>'BTC']
     	);
     	if(!empty($array)){
     		foreach($array as $key=>$value){
     			Currency::create($value);
     		}
     	}
    }
}
