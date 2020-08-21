<?php

use Illuminate\Database\Seeder;
use App\ExchangeRate;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
    		['currency'=>'PM','from_currency'=>'NGN','to_currency'=>'PM','amount'=>'50','buy'=>'1','sell'=>'0'],
     		['currency'=>'PM','from_currency'=>'PM','to_currency'=>'NGN','amount'=>'450','buy'=>'0','sell'=>'1'],
            ['currency'=>'BTC','from_currency'=>'NGN','to_currency'=>'BTC','amount'=>'60','buy'=>'1','sell'=>'0'],
     		['currency'=>'BTC','from_currency'=>'BTC','to_currency'=>'NGN','amount'=>'90','buy'=>'0','sell'=>'1'],
            ['currency'=>'NGN','from_currency'=>'PM','to_currency'=>'BTC','amount'=>'70','buy'=>null,'sell'=>null],
     		['currency'=>'NGN','from_currency'=>'BTC','to_currency'=>'PM','amount'=>'100','buy'=>null,'sell'=>null],
         );
        if(!empty($array)){
        	foreach($array as $val){
        		ExchangeRate::create($val);
        	}
        }
    }
}
