<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewTransactionReceivedEvent;
use App\Events\NewTransferSendEvent;
use App\Currency;
use App\BankDetail;
use App\Transaction;
use App\Type;
use App\ExchangeRate;
use App\Settings;
use App\Raves;
use App\Transfer;
use Auth;
use Validator;
use Crypt;
use Carbon;

class Web extends Controller
{
    protected $pmConfs,$rubies,$btcConfs;
    public function __construct(){        
        $this->pmConfs = Settings::where('type_id','2')->first();
        $this->btcConfs = Settings::where('type_id','3')->first();
        $this->rubies = Settings::where('type_id','4')->first();
    }

    public function index(){
        $data = Currency::orderBy('id','ASC')->get();
        $currency = ExchangeRate::where('buy','<>',null)->where('sell','<>',null)->distinct()->get(['currency']);
        $buy = array();$sell = array();$rate = array();
        foreach($currency as $key=>$val){
            $rate[$key]["currency"] = $val->currency;

            $rate[$key]["sell"] = ExchangeRate::where('buy','<>',null)->where('sell','<>',null)->where('sell','1')->where('currency',$val->currency)->first();

            $rate[$key]["buy"] = ExchangeRate::where('buy','<>',null)->where('sell','<>',null)->where('buy','1')->where('currency',$val->currency)->first();
        }
        return view('web.index',compact('data','rate'));
    }

    public function faq(){
        return view('web.faq');
    }

    public function store(Request $request){
    	$validator = Validator::make($request->all(),[
    		'amount' => 'required|numeric',
    		'from_currency' => 'required',
    		'to_currency' => 'required'
    	],[
    		'amount.required' => "Please enter the amount",
    		'from_currency.required' => "Please enter the currency",
    		'to_currency.required' => "Please enter the currency"
    	]);    	
    	if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        // cookie('amount', $request->amount, 15);
        session(['amount'=>$request->amount,'from_currency'=>$request->from_currency,'to_currency'=>$request->to_currency]);
        session(['previousURL'=>$request->previousURL]);
        if(!empty(Auth::user())){
            $type = Type::where('short_name',$request->to_currency)->first();
            // print_r($type->id);die;
            $bank = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>$type->id])->first();
            // print_r($bank);die;
        	if(Auth::user()->id != "1" && !empty($bank)){
                if($bank->isVerified == "1"){
                    $type = Type::where('short_name',$request->from_currency)->first();
                    if($type->id == "1"){
                        cookie('from_currency', $request->from_currency, 15);
                        /*session(['from_currency'=>$request->from_currency,'to_currency'=>$request->to_currency,'amount'=>$request->amount]);*/
                        $amount = Crypt::encrypt($request->amount);
                        $from_currency = Crypt::encrypt($request->from_currency);
                        $to_currency = Crypt::encrypt($request->to_currency);
                        $status = Crypt::encrypt($request->status);
                        return redirect()->route('payMoney',['amount'=>$amount,'from_currency'=>$from_currency,'to_currency'=>$to_currency,'status'=>$status]);
                    }else if($type->id == "2"){
                        session(['from_currency'=>$request->from_currency,'to_currency'=>$request->to_currency,'amount'=>$request->amount]);
                        $bankInfo = Settings::where('type_id',$type->id)->first();
                        // echo "<pre>";print_r($bankInfo);die;
                        $pm = $this->pmVerify($bankInfo->bank_username,$bankInfo->bank_password,$bankInfo->bank_account_no);
                        return view('web.pm')->with('payee_account',$bankInfo->bank_account_no)->with('amount',$request->amount)->with('payee_name',$pm[0]);
                    }else if($type->id == "3"){
                        session(['from_currency'=>$request->from_currency,'to_currency'=>$request->to_currency,'amount'=>$request->amount]);
                        $to_address = Settings::where('type_id','3')->first();
                        return view('bitcoin.btc')->with(['amount'=>$request->amount]);
                        // echo Carbon::now();die;
                        // echo "BTC";die;
                    }
                }else{
                    return redirect()->route('home.verify',['type'=>Crypt::encrypt($bank->type_id)])->withInput()->with('error','Please enter amount which we have sent you.!');
                    // return redirect('verify/'.Crypt::encrypt($bank->type_id))->with('error','Please enter bank details which you want to convert first.!');
                }
        	}else{
        		return redirect('profile/'.Crypt::encrypt($type->id))->with('error','Please enter bank details which you want to convert first.!');
        	}
        }else{
        	return redirect()->route('login')->with('error','Please login first before proceed.!');
        }

    }

    public function exchangeRate(Request $request){
        $data = ExchangeRate::where(['from_currency'=>$request->from_currency,'to_currency'=>$request->to_currency])->first();
        if(!empty($data) && $request->amount != ""){
            $displayRate = $request->amount * $data->amount;
            if(!empty($displayRate)){
                return response()->json(
                    array(
                        'amount' => $displayRate,
                        'success' => '1',
                        'msg' => '<h4 style="color:green;">You will receive <b>'.$displayRate.' '.$request->to_currency.'</b></h4>'
                    )
                );
            }else{
                return response()->json(
                    array(
                        'amount' => '',
                        'success' => '0',
                        'msg' => 'Error'
                    )
                );
            }
        }else{
            return response()->json(
                    array(
                        'amount' => '',
                        'success' => '0',
                        'msg' => 'There is an internal server error'
                    )
                );
        }
    }

    public function getCurrency(Request $request){
        if($request->ajax()){
            $data = Currency::all();
            return response()->json($data);
        }else{
            return abort('404');
        }
    }

    public function pmSuccess($number=null){
        $client = new \GuzzleHttp\Client();
        // $api = 'https://perfectmoney.is/acct/historycsv.asp?startmonth=7&startday=22&startyear=2020&endmonth=7&endday=24&endyear=2020&AccountID=3908528&PassPhrase=12Durex@&Account=U9831864&payment_id=ecurrencydevWZuKDImvFMmbLe2bK&desc=1';
        /*****Change year issue solution remain*****/
        $now = Carbon::now();
        $api =  'https://perfectmoney.is/acct/historycsv.asp?startmonth='.$now->month.'&startday='.($now->day - 1).'&startyear='.$now->year.'&endmonth='.$now->month.'&endday='.$now->day.'&endyear='.$now->year.'&AccountID='.$this->pmConfs->bank_username.'&PassPhrase='.$this->pmConfs->bank_password.'&Account='.$this->pmConfs->bank_account_no.'&payment_id='.$number.'&desc=1';
        $response = $client->request('GET',$api);
        $result = $response->getBody()->getContents();
        $result = explode(',',$result);
        // echo "<pre>";print_r($result);die;
        // echo "<pre>";print_r(\Str::contains($result[0],'Time'));die;
        if(strpos($result[0],'Error:') != true){            
            if(strpos($result[9],"No Records Found") != true){
                $data = Raves::where('txn_Ref',$number)->first();
                if(empty($data)){
                    $transferAmount = ExchangeRate::where(['from_currency'=>session('from_currency'),'to_currency'=>session('to_currency')])->first();
                    if(isset($transferAmount) && $transferAmount != ""){
                        $rave = new Raves;
                        $rave->user_id = Auth::user()->id;
                        $rave->txn_id = $result[11];
                        $rave->txn_Ref = $number;
                        $rave->txn_flwRef = "";
                        $rave->currency = $result[12];
                        $rave->amount = $result[13];
                        $rave->charges = $result[14];
                        $rave->txn_status = "1";
                        $save = $rave->save();
                        if($save){
                            $transaction = new Transaction;
                            $transaction->user_id = Auth::user()->id;
                            $transaction->rave_id = $rave->id;
                            $transaction->amount = $result[13];
                            $transaction->transferAmount = $transferAmount->amount * $result[13];
                            $transaction->charges = $result[14];
                            $transaction->from_currency = session('from_currency');
                            $transaction->to_currency = session('to_currency');
                            $transaction->status = "0";
                            $transaction->created_at = date('Y-m-d h:i:s');
                            $save = $transaction->save();
                            event(new NewTransactionReceivedEvent($transaction));
                            if(session('to_currency') == "BTC" || $transaction->to_currency == "BTC"){
                                $toAddress = BankDetail::where('type_id','3')->first();
                                $fromAddress = $this->btcConfs->account_no;
                                $this->sendBtcTransfer($transaction->id,$transaction->transferAmount,$fromAddress,$toAddress->account_no);
                            }
                            return view('rave.pm')->with('success', 'We have receved your payment.we will verify and transfer currency in your account');
                        }else{
                            return view('rave.pm')->with('error', 'Something went wrong.Please contact to administrator');
                        }
                    }else{
                        return redirect('/')->with('error','Something went to wrong.please try after sometime.');
                    }
                }else{
                    return view('rave.pm')->with('error','We have received your payment yet!.please wait a while.If already done then please go to home');                
                }
            }else{
                return view('rave.pm')->with('error','We have not received payment yet!.');
            }
        }else{
            return view('rave.pm')->with('error','Error in trnsaction.');
        }
    }

    public function sendBtcTransfer($transactionID,$amount,$from,$to){
        $amount = $amount / 100000000;
        $client = new \GuzzleHttp\Client();
        $api = config('rave.ngrok').$this->btcConfs->btc_address.'/payment?password=Shreeji@1&to='.$to.'&amount='.$amount.'';
        $response = $client->request('GET',$api);
        $statusCode = $response->getStatusCode();
        $result = $response->getBody()->getContents();
        echo "<pre>";print_r($result);die;
        if($result->tx_hash != ""){
            $rave = new Raves;
            $rave->user_id = Auth::user()->id;
            $rave->txn_id =  $result->tx_hash;
            $rave->txn_Ref =  "";
            $rave->txn_flwRef =  "";
            $rave->currency = "BTC"; //dynamic
            $rave->amount =  abs($amount);
            $rave->charges =  "";
            $rave->txn_status = "1";
            $save = $rave->save();
            if($save){
                $transfer = new Transfer;
                $transfer->user_id = Auth::user()->id;
                $transfer->type_id = "3";
                $transfer->transaction_id = $transactionID;
                $transfer->draccount = $this->btcConfs->account_no;
                $transfer->craccount = $to;
                $transfer->ref_no = $rave->txn_id;
                $transfer->amount = $amount;
                $tsave = $transfer->save();
                if($tsave){
                    $transaction = Transaction::find($transactionID);
                    $transaction->status = "1";
                    $transaction->updated_at = Carbon::now();
                    $transaction->save();
                    event(new NewTransferSendEvent($transfer));
                }
            }
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

    public function pmCancel(Request $request){
        switch ($request->method()) {
            case 'POST':
                return redirect('/')->with('error','You have cancel this payement');
            break;

            case 'GET':
                return redirect('/')->with('error','You have cancel this payement');
            break;
        }
    }

    public function balanceCheck($account_no){
        $client = new \GuzzleHttp\Client();
        $api = 'https://openapi.rubiesbank.io/v1/balanceenquiry';
        $headers = array(
            'Authorization'=> $this->rubies->secret_key,
            'Content-Type' => 'application/json'
        );   
        $body = array(
            'accountnumber' => $account_no
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

    public function sendAmount($sent_amount,$account_no,$bank_code,$bank_name,$account_name,$ac_name){
        $client = new \GuzzleHttp\Client();
        $api = 'https://openapi.rubiesbank.io/v1/fundtransfer';
        $headers = array(
            'Authorization'=> $this->rubies->secret_key,
            'Content-Type' => 'application/json'
        );
        $body = array(
            'reference' => \Str::random(20),
            'amount' => $sent_amount,
            'narration' => "Verify Amount",
            'craccountname' => $account_name,
            'bankname' => $bank_name,
            'draccountname' => $ac_name,
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
    }

    public function autoTransfer(Request $request){
        $data = Transaction::where(['from_currency'=>'PM','to_currency'=>'NGN','status'=>'0'])->with('user')->get()->toArray();
        if(!empty($data)){
            foreach($data as $key=>$val){
                // print_r($val['user']['id']);die;
                /******** From Admin Amount ***********/
                if($this->rubies->min_amount >= $val["amount"]){
                    $exchangeRate = ExchangeRate::where(['from_currency'=>$val['from_currency'],'to_currency'=>$val['to_currency']])->first();
                    $toType = Type::where('short_name',$val['to_currency'])->first();
                    $bankDetail = BankDetail::where(['user_id'=>$val['user']['id'],'type_id'=>$toType->id])->first();
                    // $rate = $exchangeRate->amount * ($val['amount'] - $val["charges"]);
                    $rate = $val['transferAmount'];
                    $chkBalance = $this->balanceCheck($this->rubies->bank_account_no);
                    if($chkBalance->responsecode == "00" && $chkBalance->balance > $val['amount']){
                        $send = $this->sendAmount($rate,$bankDetail->account_no,$bankDetail->bank_code,$bankDetail->bank_name,$bankDetail->account_name,$chkBalance->accountname);
                        if($send){
                            $transfer = new Transfer;
                            $transfer->user_id = $val['user']['id'];
                            $transfer->type_id = $toType->id;
                            $transfer->transaction_id = $val['id'];
                            $transfer->ref_no = $send->reference;
                            $transfer->draccount = $send->draccount;
                            $transfer->craccount = $send->craccount;
                            $transfer->amount = $send->amount;
                            $save = $transfer->save();
                            if($save){
                                $update = Transaction::where('id',$val['id'])->update(['status'=>'1']);
                                event(new NewTransferSendEvent($transfer));
                                return response()->json(
                                    array(
                                        'msg' => 'Transaction successful.!',
                                        'success'=>'1',
                                        'is_admin' => Auth::user()->is_admin,
                                    )
                                );
                            }else{
                                return response()->json(
                                    array(
                                        'msg' => 'Internal server error!',
                                        'success'=>'0',
                                        'is_admin' => Auth::user()->is_admin,
                                    )
                                );
                            }
                        }else{
                            return response()->json(
                                array(
                                    'msg' => 'Error.!Maybe Not sufficient balance or other issue',
                                    'success'=>'0',
                                    'is_admin' => Auth::user()->is_admin,
                                )
                            );
                        }
                        
                    }
                }else{
                    return response()->json(
                        array(
                            'msg'=> 'Error in amount',
                            'success' => '0',
                            'is_admin' => Auth::user()->is_admin,
                        )
                    );
                }
            }
        }/*else{
            return response()->json(
                array(
                    'msg'=> 'No transaction found',
                    'success' => '0',
                    'is_admin' => Auth::user()->is_admin,
                )
            );
        }*/
    }

    /*Auto transfer for admin*/
    public function autoTransferAdmin(Request $request){
        if($request->to_currency == "NGN"){
            $data = Transaction::where(['id'=>$request->id,'to_currency'=>$request->to_currency,'status'=>'0'])->with('user')->get()->toArray();
            if(!empty($data)){
                foreach($data as $key=>$val){
                    // print_r($val['user']['id']);die;
                    /******** From Admin Amount ***********/
                    if($this->rubies->min_amount >= $val["amount"]){
                        $exchangeRate = ExchangeRate::where(['from_currency'=>$val['from_currency'],'to_currency'=>$val['to_currency']])->first();
                        $toType = Type::where('short_name',$val['to_currency'])->first();
                        $bankDetail = BankDetail::where(['user_id'=>$val['user']['id'],'type_id'=>$toType->id])->first();
                        // $rate = $exchangeRate->amount * ($val['amount'] - $val["charges"]);
                        $rate = $val['transferAmount'];
                        $chkBalance = $this->balanceCheck($this->rubies->bank_account_no);
                        if($chkBalance->responsecode == "00" && $chkBalance->balance > $val['amount']){
                            $send = $this->sendAmount($rate,$bankDetail->account_no,$bankDetail->bank_code,$bankDetail->bank_name,$bankDetail->account_name,$chkBalance->accountname);
                            if($send){
                                $transfer = new Transfer;
                                $transfer->user_id = $val['user']['id'];
                                $transfer->type_id = $toType->id;
                                $transfer->transaction_id = $val['id'];
                                $transfer->ref_no = $send->reference;
                                $transfer->draccount = $send->draccount;
                                $transfer->craccount = $send->craccount;
                                $transfer->amount = $send->amount;
                                $save = $transfer->save();
                                if($save){
                                    $update = Transaction::where('id',$val['id'])->update(['status'=>'1']);
                                    event(new NewTransferSendEvent($transfer));
                                    return response()->json(
                                        array(
                                            'msg' => 'Transaction successful.!',
                                            'success'=>'1',
                                            'is_admin' => Auth::user()->is_admin,
                                        )
                                    );
                                }else{
                                    return response()->json(
                                        array(
                                            'msg' => 'Internal server error!',
                                            'success'=>'0',
                                            'is_admin' => Auth::user()->is_admin,
                                        )
                                    );
                                }
                            }else{
                                return response()->json(
                                    array(
                                        'msg' => 'Error.!Maybe Not sufficient balance or other issue',
                                        'success'=>'0',
                                        'is_admin' => Auth::user()->is_admin,
                                    )
                                );
                            }
                            
                        }
                    }else{
                        return response()->json(
                            array(
                                'msg'=> 'Error in amount',
                                'success' => '0',
                                'is_admin' => Auth::user()->is_admin,
                            )
                        );
                    }
                }
            }else{
                return response()->json(
                    array(
                        'msg'=> 'Somthing Went Wrong',
                        'success' => '0',
                        'is_admin' => Auth::user()->is_admin,
                    )
                );
            }
        }else if($request->to_currency == "PM"){
            $data = Transaction::where(['id'=>$request->id,'to_currency'=>$request->to_currency,'status'=>'0'])->with('user')->first();
            if(!empty($data)){
                $payer = BankDetail::where(['user_id'=>$data->user->id,'type_id'=>'2'])->first();
                $string = 'eCurrency';
                $string .= \Str::random(20);
                $client = new \GuzzleHttp\Client();
                $api = 'https://perfectmoney.com/acct/confirm.asp?AccountID='.$this->pmConfs->bank_username.'&PassPhrase='.$this->pmConfs->bank_password.'&Payer_Account='.$this->pmConfs->bank_account_no.'&Payee_Account='.$payer->account_no.'&Amount='.$data->transferAmount.'&PAYMENT_ID='.$string.'';
                $f=fopen($api, 'rb');

                if($f===false){
                echo 'error openning url';
                }

                // getting data
                $out=array(); $out="";
                while(!feof($f)) $out.=fgets($f);

                fclose($f);

                // searching for hidden fields
                if(!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $out, $result, PREG_SET_ORDER)){
                    return array('msg'=>'Ivalid output','success'=>'0');
                }
                $array=array();
                foreach($result as $item){            
                    $key=$item[1];
                    if($key === "ERROR"){
                        return array('msg'=>$item[2],'success'=>'0');
                    }
                    $array[$key]=$item[2];
                }
                $rave = new Raves;
                $rave->user_id = Auth::user()->id;
                $rave->txn_id =  $array['PAYMENT_BATCH_NUM'];
                $rave->txn_Ref =  $array['PAYMENT_ID'];
                $rave->txn_flwRef =  "";
                $rave->currency = "NGN"; //dynamic
                $rave->amount =  abs($array['PAYMENT_AMOUNT']);
                $rave->charges =  "";
                $rave->txn_status = "1";
                $save = $rave->save();
                if($save){
                    $transfer = new Transfer;
                    $transfer->user_id = Auth::user()->id;
                    $transfer->type_id = "2";
                    $transfer->transaction_id = $data->id;
                    $transfer->draccount = $array['Payer_Account'];
                    $transfer->craccount = $array['Payee_Account'];
                    $transfer->ref_no = $array['PAYMENT_ID'];
                    $transfer->amount = $array['PAYMENT_AMOUNT'];
                    $tsave = $transfer->save();
                    if($tsave){
                        $transaction = Transaction::findOrFail($data->id);
                        $transaction->status = "1";
                        $transaction->updated_at = Carbon::now();
                        $transaction->save();
                        event(new NewTransferSendEvent($transfer));
                    }
                }
                return response()->json(
                    array(
                        'msg'=> 'Transfer successfully',
                        'success' => '1',
                        'is_admin' => Auth::user()->is_admin,
                    )
                );
                // return array('msg'=>'Transfer successfully','success'=>'1','data'=>$array);
            }
        }else if($request->to_currency == "BTC"){
            $data = Transaction::where(['id'=>$request->id,'to_currency'=>$request->to_currency,'status'=>'0'])->with('user')->first();
            if(!empty($data)){
                $toAddress = BankDetail::where(['user_id'=>$data->user->id,'type_id'=>'2'])->first();
                $fromAddress = $this->btcConfs->account_no;
                $res = $this->sendBtcTransfer($request->id,$trnsaction->transferAmount,$fromAddress,$toAddress);
                if($res){
                    return response()->json(
                        array(
                            'success'=> '1',
                            'msg' => 'Status has been successfully changed',
                            'is_admin' => Auth::user()->is_admin,
                        )
                    );
                }else{
                    return response()->json(
                        array(
                            'success' => '0',
                            'msg' => 'Status has not been successfully changed',
                            'is_admin' => Auth::user()->is_admin,
                        )
                    );
                }
            }else{
                return response()->json(
                    array(
                        'success' => '0',
                        'msg' => 'No transaction found',
                        'is_admin' => Auth::user()->is_admin,
                    )
                );
            }
            /*$res = Transaction::find($request->id)->update(['status'=>'1']);*/
            /*if($res){
                $transfer = new Transfer;
                $transfer->user_id = Auth::user()->id;
                $transfer->type_id = "3";
                $transfer->transaction_id = $request->id;
                $transfer->draccount = "";
                $transfer->craccount = "";
                $transfer->ref_no = "";
                $transfer->amount = "";
                $tsave = $transfer->save();   
                if($tsave){
                    return response()->json(
                        array(
                            'success'=> '1',
                            'msg' => 'Status has been successfully changed',
                            'is_admin' => Auth::user()->is_admin,
                        )
                    );
                }else{
                    return response()->json(
                        array(
                            'success' => '0',
                            'msg' => 'Status has not been successfully changed',
                            'is_admin' => Auth::user()->is_admin,
                        )
                    );
                }
            }else{
                return response()->json(
                    array(
                        'success' => '0',
                        'msg' => 'Status has not been changed',
                        'is_admin' => Auth::user()->is_admin,
                    )
                );
            }*/
        }
    }


    /*public function transaction($from_currency,$to_currency,$amount){
        $from_currency = Crypt::decrypt($from_currency);
        $to_currency = Crypt::decrypt($to_currency);
        $amount = Crypt::decrypt($amount);
        if($from_currency != "" && $to_currency != "" && $amount != ""){
            $type = Type::where('short_name',$from_currency)->first();
            if($type->id == "1"){
                return view('rave.index');
                // return redirect('/formpay')->with('amount',$amount);
            }else if($type->id == "2"){

            }else if($type->id == "3"){

            }else{

            }
        }else{
            return abort(404);
        }
        // echo "SDf";die;
    }*/
}
