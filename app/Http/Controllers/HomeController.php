<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Crypt;
use Validator;
use App\User;
use App\BankDetail;
use App\Settings;
use App\Transaction;
use Carbon;
use Guzzle\Http\Exception\ClientErrorResponseException;


class HomeController extends Controller
{
    protected $confs;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->confs = Settings::where(['type_id'=>'4','user_id'=>'1'])->first();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // echo $confs;die;
        // $this->checkBankAmount("0005032369");
        // $data = BankDetail::where('user_id',Auth::user()->id)->first();
        if(Auth::user()->is_admin == "0"){
            $data = User::find(Auth::user()->id)->bank_detail;
            // print_r(Auth::user()->email_verified_at);die;
            if(Auth::user()->isVerified == "0"){
                if(Auth::user()->email_verified_at == null || Auth::user()->email_verified_at == ""){
                    User::where('id',Auth::user()->id)->update(['email_verified_at'=>Carbon::now()]);    
                }
                User::where('id',Auth::user()->id)->update(['isVerified'=>'1']);
                return redirect()->route('home')->with('success','Email verified successfully');
                // return redirect('email/verify')->with('success','Please check your email and verify.!');
            }else if(!empty($data) && $data != ""){
                $bank = BankDetail::where(['user_id'=>Auth::user()->id,'isVerified'=>'0'])->where('isAttempt','<>','0')->orderBy('created_at', 'desc')->first();
                if(!empty($bank)){
                    return redirect()->route('home.verify',['type'=>Crypt::encrypt($bank->type_id)])->with('success','Please check your account and verify it.!');
                    // return view('web.verify');
                }
                $ngn = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>'1'])->where('isAttempt','<>','0')->first();
                $ngnVerfied = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>'1','isVerified'=>'1'])->get();
                $pm  = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>'2'])->first();
                $btc = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>'3'])->first();
                $pms = Settings::where('type_id','2')->first();
                $bank = $this->getBankList();
                $transaction = User::find(Auth::user()->id)->transaction->sortByDesc('id');
                // return view('home',compact('transaction'))->with('bank_detail',$data)->with('success','Email verified successfully');
                return view('web.profile',compact('ngn','ngnVerfied','pm','btc','bank','pms','transaction'))->with('type','');
            }else{
                User::where('id',Auth::user()->id)->update(['isVerified'=>'1']);
                return redirect()->route('profile')->with('success','Email verified successfully');
                /* if(strpos(url()->previous(),"/") !== false){
                    return redirect()->route('profile')->with('error','Please enter bank details which you want to convert first.!');
                } */
            }
        }else{
            return abort('404','You are not authorized');
        }
    }

    public function adminHome()
    {
        $data = array(
            'total' => Transaction::all()->count(),
            'month_total' => Transaction::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at',  Carbon::now()->year)->count(),
            'success' => Transaction::where('status','1')->count(),
            'month_success' => Transaction::where('status','1')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at',  Carbon::now()->year)->count(),
            'pending' => Transaction::where('status','0')->count(),
            'month_pending' => Transaction::where('status','0')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at',  Carbon::now()->year)->count(),
            'reject' => Transaction::where('status','2')->count(),
            'month_reject' => Transaction::where('status','2')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at',  Carbon::now()->year)->count() 
        );
        return view('admin.home',compact('data'));
    }

    public function randNumber($min, $max, $decimals = 0) {
        $scale = pow(10, $decimals);
        return mt_rand($min * $scale, $max * $scale) / $scale;
    }

    public function transferBank($array){
        $transfer = Rave::accountVerification($array);
        $seckey = array('seckey' => 'FLWSECK_TEST-8a84b0d2352610b8369fdbc2b9eac03d-X');
        $arrdata = array_merge($seckey,$arrdata);
        echo "<pre>";print_r($transfer);die;
        $transfer = Rave::initiateTransfer($array);
        echo "<pre>";print_r($transfer);die;
        $fetch = Rave::fetchTransfer($transfer->data->id,"",$transfer->data->reference);
        echo "<pre>";print_r($fetch);die;
    }

    public function getBankList(){
        $client = new \GuzzleHttp\Client();
        $api = 'https://openapi.rubiesbank.io/v1/banklist';
        $headers = array(
            'Authorization'=> $this->confs->secret_key,
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
        if(!empty($result) && $result->responsecode == "00"){
            $result = $result->banklist;
        }
        return $result;
    }

    public function profile($type=null){
        if(Auth::user()->is_admin == "0"){
            if($type != ""){
                $type = Crypt::decrypt($type);
            }
            $ngn = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>'1'])->where('isAttempt','<>','0')->first();
            $ngnVerfied = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>'1','isVerified'=>'1'])->get();
            $pm  = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>'2'])->first();
            $btc = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>'3'])->first();
            $pms = Settings::where('type_id','2')->first();
            $bank = $this->getBankList();
            $transaction = User::find(Auth::user()->id)->transaction->sortByDesc('id');
            /*$bank = Rave::listofBankForTransfer("NG");
            if($bank->code == "200" && $bank->body->status == "success"){
                $bank = $bank->body->data;    
            }*/
            // echo "<pre>";print_r($bank);die;
            return view('web.profile',compact('ngn','ngnVerfied','pm','btc','type','bank','pms','transaction'));
        }else{
            return abort('404','You are not authorized');
        }
    }

    public function checkBankAmount($account_number){
        $client = new \GuzzleHttp\Client();
        $api = 'https://openapi.rubiesbank.io/v1/balanceenquiry';
        $headers = array(
            'Authorization'=> $this->confs->secret_key,
            'Content-Type' => 'application/json'
        );   
        $body = array(
            'accountnumber' => $account_number
        );
        $response = $client->request('POST',$api,
            [
                'headers' => $headers,
                'body'=> json_encode($body)
            ]
        );
        $result = json_decode($response->getBody()->getContents());
        return $result;
    }

    public function sendAmount($sent_amount,$account_no,$bank_code,$bank_name,$account_name){
        $client0 = new \GuzzleHttp\Client();
        $api0 = 'https://openapi.rubiesbank.io/v1/balanceenquiry';
        $headers0 = array(
            'Authorization'=> $this->confs->secret_key,
            'Content-Type' => 'application/json'
        );
        $body0 = array(
            'accountnumber' => $this->confs->bank_account_no
        );
        $response0 = $client0->request('POST',$api0,
            [
                'headers' => $headers0,
                'body'=> json_encode($body0)
            ]
        );
        $result0 = json_decode($response0->getBody()->getContents());
        $client = new \GuzzleHttp\Client();
        $api = 'https://openapi.rubiesbank.io/v1/fundtransfer';
        $headers = array(
            'Authorization'=> $this->confs->secret_key,
            'Content-Type' => 'application/json'
        );
        $body = array(
            /*"reference": "ABCDEF194665265111121",
            "narration": "Veify Amount",
            "craccountname": "Emblem Investment LTD",
            "bankname": "GUARANTY TRUST BANK PLC",
            "draccountname": "RUBIES MICROFINANCE BANK",
            "craccount": "6462329468",
            "bankcode": "090175"*/
            'reference' => \Str::random(20),
            'amount' => $sent_amount,
            'narration' => "Verify Amount",
            'craccountname' => $account_name,
            'bankname' => $bank_name,
            'draccountname' => $result0->accountname,
            'craccount' => $account_no,
            'bankcode' => $bank_code
        );
        $response = $client->request('POST',$api,
            [
                'headers' => $headers,
                'body'=> json_encode($body)
            ]
        );
        $result = json_decode($response->getBody()->getContents());
        return $result;
        /*if($result->transactionstatus == "Success" && $result->responsecode == "00"){
            return $result->responsemessage;
        }
        // echo $response->getStatusCode();die; // 200
        echo "<pre>";print_r(json_decode($response->getBody()->getContents()));die;*/
    }

    public function updateProfile(Request $request){
        /* $transferInfo = array(
            'account_bank' => '044',
            'account_number' => '0690000032',
            // 'amount' => '100',
            // 'currency' => 'NGN'
        );
        $transfer = $this->transferBank($transferInfo); */
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            // 'email'  => 'required|email',
            'mobile' => 'required|unique:users'
        ]);
        if($request->type != ""){
            if($request->type == "1"){
                $validator = Validator::make($request->all(), [
                    'bank_code' => 'required',
                    'account_no'   => 'required',
                    'account_name'  => 'required'
                ],[
                    'account_no.unique' => 'This is account no. is already link up with other account',
                    'account_name.unique' => 'This is account name is already link up with other account'
                ]);
                $chkAccount = BankDetail::where(['type_id'=>$request->type,'account_no'=>$request->account_no])->where('isAttempt','<>','0')->count();
                if($chkAccount > 5){
                    return redirect()->back()->withInput()->with('error','This account already link up with 5 accounts');
                }
            }else if($request->type == "2"){
                $validator = Validator::make($request->all(), [
                    'account_no'   => 'required|regex:/^\S*$/u',
                    /*'account_name'  => 'required',
                    'account_password' => 'required'*/
                ]);
                $chkAccount = BankDetail::where(['type_id'=>$request->type,'account_no'=>$request->account_no])->where('isAttempt','<>','0')->count();
                if($chkAccount > 5){
                    return redirect()->back()->withInput()->with('error','This account already link up with 5 accounts');
                }
            }else if($request->type == "3"){
                $validator = Validator::make($request->all(), [
                    'account_no'   => 'required',
                ]);
                $chkAccount = BankDetail::where(['type_id'=>$request->type,'account_no'=>$request->account_no])->where('isAttempt','<>','0')->count();
                if($chkAccount > 5){
                    return redirect()->back()->withInput()->with('error','This account already link up with 5 accounts');
                }
            }
        }
        if($request->change_password == "chnge_pwd"){
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);
        }
        if ($validator->fails()) {
            // return redirect()->back()->withInput()->withErrors($validator);
            return redirect()->back()->withInput()->with('error',$validator->messages()->first());
        }
        if($request->type != ""){
            $data = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>$request->type])->first();
            if(empty($data)){
                if($request->type == "1"){
                    $bankinfo = explode(',', $request->bank_code);
                    $ngn = $this->ngnVerify($request->account_no,$bankinfo[0]);
                    // echo "<pre>";print_r($ngn);die;
                    if($ngn->responsemessage == "success" && $ngn->responsecode == "00"){
                        return view('bitcoin.ngn')->with(['account_name'=>$ngn->accountname,'type'=>$request->type,'account_no'=>$ngn->accountnumber,'bank_code'=>$bankinfo[0],'bank_name'=>$bankinfo[1]]);
                    }else{
                        return redirect('profile/'.Crypt::encrypt($request->type))->with('error',"You have not verfied.");
                    }
                }else if($request->type == "2"){
                    $pm = $this->pmVerify(Crypt::decrypt($request->account_name),Crypt::decrypt($request->account_password),$request->account_no);
                    if($pm[0] != "" && $pm[0] == "ERROR"){
                        return redirect('profile/'.Crypt::encrypt($request->type))->with('error',$pm[1]);
                    }else{
                        return view('bitcoin.pm')->with(['account_name'=>$pm[0],'type'=>$request->type,'account_no'=>$request->account_no]);
                    }
                }else{
                    $bank = new BankDetail;
                    $bank->user_id = Auth::user()->id;
                    $bank->type_id = $request->type;
                    $bank->account_no = $request->account_no;
                    // $bank->ifsc_code = $request->ifsc_code;
                    // $bank->sent_amount = $this->randNumber(0,6,2);
                    $bank->sent_amount = $this->randNumber(0,6,2);
                    $bank->isVerified = "1";
                    $update = $bank->save();
                }
            }else{
                if($request->type == "1"){
                    $bankdata = explode(',', $request->bank_code);
                    $updateNGN = $this->ngnVerify($request->account_no,$bankdata[0]);
                    if($updateNGN->responsemessage == "success" && $updateNGN->responsecode == "00"){
                        return view('bitcoin.ngn')->with(['account_name'=>$updateNGN->accountname,'type'=>$request->type,'account_no'=>$updateNGN->accountnumber,'bank_code'=>$bankdata[0],'bank_name'=>$bankdata[1]]);
                    }else{
                        return redirect('profile/'.Crypt::encrypt($request->type))->with('error',"You have not verfied.");
                    }
                    // $this->sendAmount($data->sent_amount,$data->account_no,$data->bank_code);
                }else if($request->type == "2"){
                    $updatePM = $this->pmVerify(Crypt::decrypt($request->account_name),Crypt::decrypt($request->account_password),$request->account_no);
                    // print_r($updatePM);die;
                    if($updatePM[0] != "" && $updatePM[0] == "ERROR"){
                        return redirect('profile/'.Crypt::encrypt($request->type))->with('error',$updatePM[1]);
                    }else{
                        return view('bitcoin.pm')->with(['account_name'=>$updatePM[0],'type'=>$request->type,'account_no'=>$request->account_no]);
                    }
                }else{
                    $data->type_id = $request->type;
                    $data->account_no = $request->account_no;
                    $data->bank_code = "";
                    // $data->ifsc_code = $request->ifsc_code;
                    $data->sent_amount = $this->randNumber(0,6,2);
                    $data->isVerified = "1";
                    $update = $data->save();
                }
                if($update && $request->type == "1"){
                    User::where('id',Auth::user()->id)->update(['isVerified'=>0]);
                }
            }
        }else if($request->change_password == "chnge_pwd"){
            $current_password = Auth::User()->password;
            if(Hash::check($request->old_password,$current_password)){
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($request->password);
                $user->update();
                return redirect()->route('home')->withInput()->with('success','Password changed successfully!');
            }else{
                return redirect()->route('profile')->withInput()->with('error','Please enter correct current password');    
            }
        }else{
            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $update = $user->save();
        }
        if($update){
            session(['type' => $request->type]);
            if($request->type != "" && $request->type == "1"){
                return redirect()->route('home.verify',['type'=>Crypt::encrypt($request->type)])->withInput()->with('success','Details updated successfully Please check your account and verify it.!');
            }
            return redirect()->route('home')->withInput()->with('success','Profile updated successfully!');
        }else{
            return redirect()->route('home')->withInput()->with('error','Details not updated!');
        }
    }

    public function pmAlert(Request $request){
        $bank = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>$request->type])->first();
        if(empty($bank)){
            $data = new BankDetail;
            $data->user_id = Auth::user()->id;
            $data->type_id = $request->type;
            $data->account_no = $request->account_no;
            $data->isVerified = "1";
            $save = $data->save();
            if($save){
                return redirect('home')->with('success','You have successfully verified your account');
            }else{
                return redirect('home')->with('error','Error in Verification');
            }
        }else{
            $bank->user_id = Auth::user()->id;
            $bank->type_id = $request->type;
            $bank->account_no = $request->account_no;
            $bank->isVerified = "1";
            $bank->updated_at = Carbon::now();
            $save = $bank->save(); 
            if($save){
                return redirect('home')->with('success','You have successfully verified your account');
            }else{
                return redirect('home')->with('error','Error in Verification');
            }
        }
    }

    public function ngnAlert(Request $request){
        $bank = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>$request->type])->first();
        if(empty($bank)){
            $data = new BankDetail;
            $data->user_id = Auth::user()->id;
            $data->type_id = $request->type;
            $data->bank_code = $request->bank_code;
            $data->bank_name = $request->bank_name;
            $data->account_no = $request->account_no;
            $data->account_name = $request->account_name;
            $data->sent_amount = $this->randNumber(1,2,2);
            // $data->sent_amount = "10";
            $save = $data->save();
            if($save){
                // if(true){
                $verify = $this->checkBankAmount($this->confs->bank_account_no);
                if($verify->balance >= $data->sent_amount){
                    $send = $this->sendAmount($data->sent_amount,$data->account_no,$data->bank_code,$data->bank_name,$data->account_name);
                    if($send->transactionstatus == "Success" && $send->responsecode == "00"){
                    // if(true){
                        return redirect()->route('home.verify',['type'=>Crypt::encrypt($request->type)])->withInput()->with('success','Details updated successfully Please check your account and verify it.!');
                    }else{
                        return redirect('profile/'.Crypt::encrypt($request->type))->with('error','Error in verification');
                    }
                }else{
                    return redirect()->route('home')->with('error','There is an internal server error.Please contact to administrator');
                }
            }else{
                return redirect('home')->with('error','Error in Verification');
            }
        }else{
            $bank->user_id = Auth::user()->id;
            $bank->type_id = $request->type;
            $bank->bank_code = $request->bank_code;
            $bank->bank_name = $request->bank_name;
            $bank->account_no = $request->account_no;
            $bank->account_name = $request->account_name;
            $bank->sent_amount = $this->randNumber(1,2,2);
            // $bank->sent_amount = "10";
            $bank->updated_at = Carbon::now();
            $save = $bank->save();
            if($save){
                $verify = $this->checkBankAmount($this->confs->bank_account_no);
                if($verify->balance >= $data->sent_amount){
                    $usend = $this->sendAmount($bank->sent_amount,$bank->account_no,$bank->bank_code,$bank->bank_name,$bank->account_name);
                    if($usend->transactionstatus == "Success" && $usend->responsecode == "00"){
                        return redirect()->route('home.verify',['type'=>Crypt::encrypt($request->type)])->withInput()->with('success','Details updated successfully Please check your account and verify it.!');
                    }else{
                        return redirect('profile/'.Crypt::encrypt($request->type))->with('error','Error in verification');
                    }
                }else{
                    return redirect()->route('home')->with('error','There is an internal server error.Please contact to administrator');
                }
            }else{
                return redirect('home')->with('error','Error in Verification');
            }
        }
        // echo $bank->sent_amount;die;
    }

    public function ngnVerify($account_no,$bankCode){        
        $body = array(
            'accountnumber' => $account_no,
            'bankcode' => $bankCode,
        );
        $api = 'https://openapi.rubiesbank.io/v1/nameenquiry';
        $headers = array(
            'Authorization' => $this->confs->secret_key,
            'Content-Type' => 'application/json'
        );
        $client = new \GuzzleHttp\Client();
        try{
            $response = $client->request('POST',$api,['headers' => $headers,'body' => json_encode($body)]);
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return $result;
        }catch(\GuzzleHttp\Exception\ClientException $exception){
            $response = $exception->getResponse();
            $result = json_decode($response->getBody()->getContents());
            return $result;
        }
    }

    public function ngnAutoFetch(Request $request){
        if($request->ajax()){
            $account_no  = $request->account_no;
            $bankCode  = $request->bank_code;
            if($account_no != "" && $bankCode != ""){
                $chkBlock = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>'1','account_no'=>$request->account_no,'bank_code'=>$request->bank_code])->where('isAttempt','=','0')->first();
                if(empty($chkBlock)){
                    $body = array(
                        'accountnumber' => $account_no,
                        'bankcode' => $bankCode,
                    );            
                    $api = 'https://openapi.rubiesbank.io/v1/nameenquiry';
                    $headers = array(
                        'Authorization' => $this->confs->secret_key,
                        'Content-Type' => 'application/json'
                    );
                    $client = new \GuzzleHttp\Client();
                    try{
                        $response = $client->request('POST',$api,['headers' => $headers,'body' => json_encode($body)]);
                        $statusCode = $response->getStatusCode();
                        $result = json_decode($response->getBody()->getContents());
                        return response()->json($result);
                    }catch(\GuzzleHttp\Exception\ClientException $exception){
                        $response = $exception->getResponse();
                        $result = json_decode($response->getBody()->getContents());
                        return response()->json($result);
                    }
                }else{
                    return response()->json(array('responsemessage'=>'This account is blocked for you.','responsecode'=>"   error"));
                }
            }
        }else{
            return abort('404');
        }
    }

    public function pmVerify($account_name,$password,$account_no){
        $client = new \GuzzleHttp\Client();
        $api = 'https://perfectmoney.is/acct/acc_name.asp?AccountID='.$account_name.'&PassPhrase='.$password.'&Account='.$account_no.'';
        $response = $client->request('GET',$api);
        $statusCode = $response->getStatusCode();
        $result = explode(":", $response->getBody()->getContents());
        return $result;
    }

    public function verifyUser(Request $request){
        $validator = Validator::make($request->all(), [
            'account_no'   => 'required',
            'ifsc_code'  => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error',$validator->messages()->first());
        }
        
        $data = BankDetail::where('user_id',Auth::user()->id)->get()->toArray();
        if(empty($data)){
            $bank = new BankDetail();
            $bank->user_id = Auth::user()->id;
            $bank->account_no = $request->account_no;
            $bank->ifsc_code = $request->ifsc_code;
            $save = $bank->save();
            /* if($save){
                $update = User::where('id',Auth::user()->id)->update(['isVerified'=>true]);
            } */
            return redirect()->route('home.verify')->withInput()->with('success','We have sent small amount to your account. Please verify that amount.');
        }else{
            // $update = User::where('id',Auth::user()->id)->update(['isVerified'=>true]);
            return redirect()->route('home')->withInput()->with('success','User already verfied');
        }
    }
}
