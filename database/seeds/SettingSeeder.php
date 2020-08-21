<?php

use Illuminate\Database\Seeder;
use App\Settings;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
        	['user_id' => '1','type_id' => '2','bank_username' => '3908528','bank_password' => '12Durex@','bank_account_no' => 'U9831864'],
            ['user_id'=>'1','type_id'=>'4','bank_account_no'=>'0005032369','min_amount'=>'100','secret_key'=>'SK-000087335-PROD-D6B45CD2ED7A4274A9E1321A647EE1BE4C2EE0D70EB74DB099DC82EF7AB102FE','bank_name'=>'','bank_code'=>''],
            ['user_id' => '1','type_id' => '3','bank_account_no'=>'','pub_key' => 'xpub6CpzGPxLj4wy4QMP9EAdWDzkUd24ZhByzhX4qKsY3SzDq5XHwXD2HJGv9aQM15iiMSjg1qXJQUBjkGe7MKp7wuGS9Cc591YZCD8QxQPr7Kx','btc_address' => '1BakB4mWvjfb2kjJrsFCtKkPK2otzKdHPC','secret_key' => '5e2415da-262a-4434-8c09-10eae8b7f3bf','app_secret_key'=>\Str::random(20)],
        );
        foreach($array as $val){
            Settings::create($val);
        }
    }
}
