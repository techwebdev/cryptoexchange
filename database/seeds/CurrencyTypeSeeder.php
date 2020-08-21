<?php

use Illuminate\Database\Seeder;
use App\Type;

class CurrencyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
    		['name'=>'Nigeria','short_name'=>'NGN'],
     		['name'=>'Perfect Money','short_name'=>'PM'],
     		['name'=>'Bitcoin Currency','short_name'=>'BTC'],
            ['name'=>'Other','short_name'=>'OTHER']
         );
         if(!empty($array)){
            foreach($array as $key=>$value){
                Type::create($value);
            }
        }
    }
}
