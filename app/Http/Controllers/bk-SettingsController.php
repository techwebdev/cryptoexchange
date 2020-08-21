<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Auth;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ngn = Settings::where(['user_id'=>Auth::user()->id,'type_id'=>'1'])->first();
        $pm  = Settings::where(['user_id'=>Auth::user()->id,'type_id'=>'2'])->first();
        $btc = Settings::where(['user_id'=>Auth::user()->id,'type_id'=>'3'])->first();
        $bank = $this->getBankList();
        $other = Settings::where(['user_id'=>Auth::user()->id,'type_id'=>'4'])->first();
        return view('admin.profile.index',compact('ngn','pm','btc','bank','other'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        /*if($request->ac_type == "1"){
            $validator = Validator::make($request->all(),[
                'bank_name' => 'required',
                'bank_account_no' => 'required',
                'bank_code' => 'required',
            ],[
                'bank_name.required' => 'bank name is required',
                'bank_account_no.required' => 'bank account no is required',
                'bank_code.required' => 'bank code is required'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }
        }
        if($request->ac_type == "2"){
            $validator = Validator::make($request->all(),[
                'bank_username' => 'required',
                'bank_password' => 'required',
                'bank_account_no' => 'required'
            ],[
                'bank_username.required' => 'bank username is required',
                'bank_password.required' => 'bank password is required',
                'bank_account_no.required' => 'bank account no is required'
            ]);
            
        }
        if($request->ac_type == "4"){
            $validator = Validator::make($request->all(),[
                'secret_key' => 'required',
                'account_number' => 'required'
            ],[
                'secret_key.required' => 'Secret key is required',
                'account_number.required' => 'Account number is required'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }
        }*/
        if($request->personal == "personal"){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'mobile' => 'required'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }

            $data = User::find(Auth::user()->id);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->mobile = $request->mobile;
            $save = $data->save();
        }
        if($request->bank_info == "bank_info"){
            $data = Settings::where(['user_id'=>Auth::user()->id,'type_id'=>$request->ac_type])->first(); //->with('user')
            if(empty($data)){
                if($request->ac_type == "1"){
                    $settings->user_id       = Auth::user()->id;
                    $settings->type_id       = $request->ac_type;
                    $settings->bank_name     = $request->bank_name;
                    $settings->bank_code     = $request->bank_code;
                    $settings->bank_account_no = $request->bank_account_no;
                    $save = $settings->save();
                }
                else if($request->ac_type == "2"){
                    $settings->user_id       = Auth::user()->id;
                    $settings->type_id       = $request->ac_type;
                    $settings->bank_username = $request->bank_username;
                    $settings->bank_password = $request->bank_password;
                    $settings->bank_account_no = $request->bank_account_no;
                    $settings->min_amount = $request->pm_min_amount;
                    $save = $settings->save();
                }else if($request->ac_type == "3"){
                    $settings->user_id         = Auth::user()->id;
                    $settings->type_id         = $request->ac_type;
                    $settings->bank_account_no = "";
                    $settings->secret_key      = $request->secret_key;
                    $settings->app_secret_key  = $request->app_secret_key;
                    $settings->pub_key         = $request->x_pub_key;
                    $settings->btc_address     = $request->btc_address;
                    $settings->min_amount      = $request->btc_min_amount;
                    $save = $settings->save();
                }else if($request->ac_type == "4"){
                    $settings->user_id         = Auth::user()->id;
                    $settings->type_id         = $request->ac_type;
                    $settings->secret_key      = $request->secret_key;
                    $settings->bank_account_no = $request->account_number;
                    $settings->min_amount      = $request->min_amount;
                    $settings->bank_name = "";
                    $settings->bank_code = "";
                    $save = $settings->save();
                }
            }else{
                if($request->ac_type == "1"){
                    $data->user_id       = Auth::user()->id;
                    $data->type_id       = $request->ac_type;
                    $data->bank_name     = $request->bank_name;
                    $data->bank_code     = $request->bank_code;
                    $data->bank_account_no = $request->bank_account_no;
                    $save = $data->save();
                }else if($request->ac_type == "2"){
                    $data->user_id       = Auth::user()->id;
                    $data->type_id       = $request->ac_type;
                    $data->bank_username = $request->bank_username;
                    $data->bank_password = $request->bank_password;
                    $data->min_amount    = $request->pm_min_amount;
                    $data->bank_account_no = $request->bank_account_no;
                    $save = $data->save();
                }else if($request->ac_type == "3"){
                    $data->type_id         = $request->ac_type;
                    $data->bank_account_no = "";
                    $data->secret_key  = $request->secret_key;
                    $data->app_secret_key  = $request->app_secret_key;
                    $data->pub_key     = $request->x_pub_key;
                    $data->btc_address = $request->btc_address;
                    $data->min_amount  = $request->btc_min_amount;
                    $save = $data->save();
                }else if($request->ac_type == "4"){
                    $data->user_id         = Auth::user()->id;
                    $data->type_id         = $request->ac_type;
                    $data->secret_key      = $request->secret_key;
                    $data->bank_account_no = $request->account_number;
                    $data->min_amount      = $request->min_amount;
                    $data->bank_name       = "";
                    $data->bank_code       = "";
                    $save = $data->save();
                }
            }
            if($save){
                return redirect()->back()->with('success', 'Data updated sucessfully!');
            }else{
                return redirect()->back()->with('success', 'Data updated sucessfully!');
            }
        }
        if($save){
            return redirect()->back()->with('success', 'Data updated sucessfully!');
        }else{
            return redirect()->back()->with('success', 'Data updated sucessfully!');
        }
    }

    public function getBankList(){
        $client = new \GuzzleHttp\Client();
        $api = 'https://openapi.rubiesbank.io/v1/banklist';
        $headers = array(
            'Authorization'=>" SK-000087335-PROD-D6B45CD2ED7A4274A9E1321A647EE1BE4C2EE0D70EB74DB099DC82EF7AB102FE",
            'Content-Type' => 'application/json'
        );
        $body = array(
            'reference' => \Str::random(20)
        );
        $response = $client->request('POST',$api,
            [
                'headers' => $headers,
                'body'=> json_encode($body)
            ]
        );
        // echo $response->getStatusCode();die; // 200
        // echo "<pre>";print_r(json_decode($response->getBody()));die;
        $result = json_decode($response->getBody());
        if($result->responsecode == "00"){
            $result = $result->banklist;
        }
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
