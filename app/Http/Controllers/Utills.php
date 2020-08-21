<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewTransactionReceivedEvent;
use App\Events\NewTransferSendEvent;
use App\User;
use App\Raves;
use App\Transaction;
use App\BitcoinPayment;
use App\ExchangeRate;
use App\Transfer;
use App\BankDetail;
use App\Settings;
use App\Type;
use Carbon;
use Auth;

class Utills extends Controller
{
    protected $ngnConfs,$pmConfs,$rubies,$confirm;
    public function __construct(){
        $this->ngnConfs = Settings::where('type_id','4')->first();
        $this->pmConfs = Settings::where('type_id','2')->first();
        $this->rubies = Settings::where('type_id','4')->first();
        $this->confirm  = 0;
    }

    public function index(){
        $users = User::where('is_admin','0')->orderBy('created_at','desc')->with('transaction')->with('transfer')->with('bank_detail')->get();
        return view('admin.users.index',compact('users'));
    }

    public function checkConfirmation(Request $request){
        $address = $request->address;
        $client = new \GuzzleHttp\Client();
        try{
            $api = 'https://blockchain.info/unspent?active='.$address.'';
            $response = $client->request('GET',$api);
            $statusCode = $response->getStatusCode();
            // echo $statusCode;die;
            $result = json_decode($response->getBody()->getContents());
            $result = $result->unspent_outputs[0];
        }catch(\GuzzleHttp\Exception\ServerException $exception){
            $response = $exception->getResponse();
            // print_r($response);die;
            $result = json_decode($response->getBody()->getContents());
        }
        if($result != "" && !empty($result) && $result->tx_index >= $this->confirm){
            return response()->json(
                array(
                    'success' => '1',
                    'data' => $result,
                    'redirect_url' => route('confirmationCallback')
                )
            );
        }else{
            return response()->json(
                array(
                    'success' => '0',
                    'data' => 'No any amount received',
                    // 'redirect_url' => route('confirmationCallback')
                )
            );
        }
    }

    public function confirmationCallback(){
        return view('rave.unspent');
    }

    /* public function checkPayments(){
        $payments = BitcoinPayment::where('status','0')->get();
        // echo "<pre>";print_r($payments);die;
        if(!empty($payments)){
            foreach($payments as $val){
                if($val->status == "0"){
                    $now = Carbon::now();
                    $to = Carbon::parse($val->created_at)->format('Y-m-d H:i:s');
                    $diff = $now->diffInHours($to);
                    if($diff > 24){
                        $delete = BitcoinPayment::find($val->id)->delete();
                    }
                    if($val->receive_amount >= $val->actual_amount){
                        $update = BitcoinPayment::where('id',$val->id)->update(['status'=>'1']);
                        $update = Raves::where('bitcoin_id',$val->id)->update(['status'=>'1']);
                        $delete = BitcoinPayment::find($val->id)->delete();
                    }else{
                        $update = BitcoinPayment::where('id',$val->id)->update(['status'=>'0']);
                    }
                }
            }
        }
    } */

    public function btcPayment(Request $request){
        // $bitcoin = BitcoinPayment::where(['user_id'=>Auth::user()->id,'from_address'=>$request->payto])->first();
        $id = Auth::user()->id;//"2";
        $formCurrency = session('from_currency'); //"BTC";
        $toCurrency = session('to_currency'); //"PM";
        $bitcoin = BitcoinPayment::where(['user_id'=>$id,'from_address'=>$request->payto,'status'=>'0'])->first();
        if(!empty($bitcoin)){
            $bitcoin->to_address = $request->payUser;
            $bitcoin->receive_amount = $request->receive_amount;
            $bitcoin->status = ($request->receive_amount + $bitcoin->receive_amount >= $bitcoin->actual_amount) ? "1" : "0";
            $bitcoin->updated_at = Carbon::now();
            $update = $bitcoin->save();
            if($update){
                // $ravePayment = Raves::where(['user_id'=>Auth::user()->id,'bitcoin_id'=>$bitcoin->id])->first();
                $rave = Raves::where(['user_id'=>$id,'bitcoin_id'=>$bitcoin->id,'txn_status'=>'0'])->first();
                if(!empty($rave)){
                    // echo $request->receive_amount;die;
                    $rave->txn_id = $request->script;
                    $rave->txn_Ref = $request->hash;
                    $rave->currency = $formCurrency;
                    $rave->amount = $request->receive_amount;
                    $rave->charges = "0";
                    // print_r($rave->amount);die;
                    $rave->txn_status = ($request->receive_amount + $rave->actual_amount >= $bitcoin->actual_amount) ? "1" : "0";
                    $rave->updated_at = Carbon::now();
                    $save = $rave->save();
                    if($save){
                        $transaction = Transaction::where(['user_id'=>$id,'rave_id'=>$rave->id,'status'=>'0'])->first();
                        if(!empty($transaction)){
                            // $transferAmountChk = ExchangeRate::where(['from_currency'=>$formCurrency,'to_currency'=>$toCurrency])->first();
                            $transaction->amount = $request->receive_amount;
                            $transaction->charges = "0";
                            // $transaction->transferAmount = $transferAmountChk->amount * ($rave->amount==="" ? 0 : $rave->amount);
                            $transaction->status = "0";
                            $transaction->updated_at = Carbon::now();
                            $transaction->save();
                            event(new NewTransactionReceivedEvent($transaction));
                            if(session('to_currency') == "NGN" || $transaction->to_currency == "NGN"){
                                $this->ngnAutoTransfer($transaction->id,$transaction->transferAmount);
                            }
                            if(session('to_currency') == "PM" || $transaction->to_currency == "PM"){
                                $payer = BankDetail::where(['user_id'=>$id,'type_id'=>'2'])->first();
                                $string = 'eCurrency';
                                $string .= \Str::random(20);
                                $this->pmAutoTransfer($transaction->id,$transaction->transferAmount,$payer->account_no,$string);   
                            }
                            $request->session()->forget(['from_currency', 'to_currency','amount']);
                            return response()->json(
                                array(
                                    'msg' => 'Bitcoin Payment successfully done.',
                                    'redirect_url' => url('/'),
                                    'success' => '1'
                                )
                            );
                            // return redirect('/')->with('success','Bitcoin Payment successfully done.');
                        }else{
                            return response()->json(
                                array(
                                    'msg' => 'No Transaction found',
                                    'success' => '0'
                                )
                            );
                        }
                    }
                }else{
                    return response()->json(
                        array(
                            'msg' => 'No Rave transaction found',
                            'success' => '0'
                        )
                    );
                }
            }
        }else{
            return response()->json(
                array(
                    'msg' => 'No transaction found',
                    'success' => '0'
                )
            );
        }
    }

    public function btcPendingPayment(Request $request){
        $id = Auth::user()->id;//"2";
        $formCurrency = session('from_currency'); //"BTC";
        $toCurrency = session('to_currency'); //"PM";
        $bitcoin = BitcoinPayment::where(['user_id'=>$id,'from_address'=>$request->payto,'status'=>'0'])->first();
        if(!empty($bitcoin)){
            $bitcoin->to_address = $request->payUser;
            $bitcoin->receive_amount = $request->receive_amount + ($bitcoin->receive_amount=== "" ? 0 : $bitcoin->receive_amount);
            $bitcoin->status = ($request->receive_amount + $bitcoin->receive_amount >= $bitcoin->actual_amount) ? "1" : "0";
            $bitcoin->updated_at = Carbon::now();
            $update = $bitcoin->save();
            if($update){
                // $ravePayment = Raves::where(['user_id'=>Auth::user()->id,'bitcoin_id'=>$bitcoin->id])->first();
                $rave = Raves::where(['user_id'=>$id,'bitcoin_id'=>$bitcoin->id,'txn_status'=>'0'])->first();
                if(!empty($rave)){
                    // echo $request->receive_amount;die;
                    $rave->txn_id = $request->script;
                    $rave->txn_Ref = $request->hash;
                    $rave->currency = $formCurrency;
                    $rave->amount = $request->receive_amount + ($rave->amount === "" ? 0 : $rave->amount);
                    $rave->charges = ($rave->charges === "" ? 0 :$rave->charges) + "0";
                    // print_r($rave->amount);die;
                    $rave->txn_status = ($request->receive_amount + $rave->actual_amount >= $bitcoin->actual_amount) ? "1" : "0";
                    $rave->updated_at = Carbon::now();
                    $save = $rave->save();
                    if($save){
                        // $transactionChk = Transaction::where(['user_id'=>$id,'rave_id'=>$rave->id,'status'=>'0'])->first();
                        if(!empty($transactionChk)){
                            $transferAmountChk = ExchangeRate::where(['from_currency'=>$formCurrency,'to_currency'=>$toCurrency])->first();
                            $transactionChk->amount = $request->receive_amount + ($transactionChk->amount === "" ? 0 : $transactionChk->amount);
                            $transaction->charges = "0";
                            // $transactionChk->transferAmount = $transferAmountChk->amount * ($rave->amount==="" ? 0 : $rave->amount);
                            $transactionChk->status = "0";
                            $transactionChk->updated_at = Carbon::now();
                            $transactionChk->save();
                            event(new NewTransactionReceivedEvent($transactionChk));
                            if(session('to_currency') == "NGN" || $transactionChk->to_currency == "NGN"){
                                $this->ngnAutoTransfer($transactionChk->id,$transactionChk->transferAmount);
                            }
                            if(session('to_currency') == "PM" || $transactionChk->to_currency == "PM"){
                                $payer = BankDetail::where(['user_id'=>$id,'type_id'=>'2'])->first();
                                $string = 'eCurrency';
                                $string .= \Str::random(20);
                                $this->pmAutoTransfer($transactionChk->id,$transactionChk->transferAmount,$payer->account_no,$string);   
                            }
                            $request->session()->forget(['from_currency', 'to_currency','amount']);
                            return response()->json(
                                array(
                                    'msg' => 'Bitcoin Payment successfully done.',
                                    'redirect_url' => url('/'),
                                    'success' => '1'
                                )
                            );
                            // return redirect('/')->with('success','Bitcoin Payment successfully done.');
                        }else{
                            return response()->json(
                                array(
                                    'msg' => 'No Transaction found',
                                    'success' => '0'
                                )
                            );
                            /*$transferAmount = ExchangeRate::where(['from_currency'=>$formCurrency,'to_currency'=>$toCurrency])->first();
                            if($transferAmount != "" && !empty($transferAmount)){
                                $transaction = new Transaction;
                                $transaction->user_id = $id;
                                $transaction->rave_id = $rave->id;
                                $transaction->amount = $rave->amount;
                                // chnage if after 23 hours
                                $transaction->transferAmount = ($transferAmount->amount === "" ? 0 : $transferAmount->amount) * $rave->amount;
                                $transaction->charges = "";
                                $transaction->from_currency = $formCurrency;
                                $transaction->to_currency = $toCurrency;
                                $transaction->status = "0";
                                $transaction->created_at = Carbon::now();
                                $transaction->save();
                                event(new NewTransactionReceivedEvent($transaction));
                                if($toCurrency == "NGN" || $transaction->to_currency == "NGN"){
                                    $this->ngnAutoTransfer($transaction->id,$transaction->transferAmount);
                                }
                                if($toCurrency == "PM" || $transaction->to_currency == "PM"){
                                    $payer = BankDetail::where(['user_id'=>$id,'type_id'=>'2'])->first();
                                    $string = 'eCurrency';
                                    $string .= \Str::random(20);
                                    $this->pmAutoTransfer($transaction->id,$transaction->transferAmount,$payer->account_no,$string);   
                                }
                                $request->session()->forget(['from_currency', 'to_currency','amount']); 
                                return redirect('/')->with('success','Bitcoin Payment successfully done.');
                            }*/
                        }
                    }
                }else{
                    return response()->json(
                        array(
                            'msg' => 'No Rave transaction found',
                            'success' => '0'
                        )
                    );
                }/*else{
                    $rave = new Raves;
                    $rave->user_id = $id;
                    $rave->txn_id = $request->script;
                    $rave->txn_Ref = $request->hash;
                    $rave->bitcoin_id = $bitcoin->id;
                    $rave->txn_flwRef = $bitcoin->order_id;
                    $rave->currency = $formCurrency;
                    $rave->amount = $request->receive_amount;
                    $rave->charges = "0";
                    $rave->txn_status = ($request->receive_amount >= $bitcoin->actual_amount) ? "1" : "0";
                    $rave->created_at = Carbon::now();
                    $save = $rave->save();
                }*/
                /*if($save){
                    $transactionChk = Transaction::where(['user_id'=>$id,'rave_id'=>$rave->id,'status'=>'0'])->first();
                    if(!empty($transactionChk)){
                        $transferAmountChk = ExchangeRate::where(['from_currency'=>$formCurrency,'to_currency'=>$toCurrency])->first();
                        $transactionChk->amount = $request->receive_amount + ($transactionChk->amount === "" ? 0 : $transactionChk->amount);
                        $transactionChk->transferAmount = ($transactionChk->amount === "" ? 0 : $transactionChk->amount);
                        $transactionChk->status = " 0";
                        $transactionChk->updated_at = Carbon::now();
                        $transactionChk->save();
                        event(new NewTransactionReceivedEvent($transactionChk));
                        if(session('to_currency') == "NGN" || $transactionChk->to_currency == "NGN"){
                            $this->ngnAutoTransfer($transactionChk->id,$transactionChk->transferAmount);
                        }
                        if(session('to_currency') == "PM" || $transactionChk->to_currency == "PM"){
                            $payer = BankDetail::where(['user_id'=>$id,'type_id'=>'2'])->first();
                            $string = 'eCurrency';
                            $string .= \Str::random(20);
                            $this->pmAutoTransfer($transactionChk->id,$transactionChk->transferAmount,$payer->account_no,$string);   
                        }
                        $request->session()->forget(['from_currency', 'to_currency','amount']);
                        return redirect('/')->with('success','Bitcoin Payment successfully done.');
                    }else{
                        $transferAmount = ExchangeRate::where(['from_currency'=>$formCurrency,'to_currency'=>$toCurrency])->first();
                        if($transferAmount != "" && !empty($transferAmount)){
                            $transaction = new Transaction;
                            $transaction->user_id = $id;
                            $transaction->rave_id = $rave->id;
                            $transaction->amount = $rave->amount;
                            // chnage if after 23 hours
                            $transaction->transferAmount = ($transferAmount->amount === "" ? 0 : $transferAmount->amount) * $rave->amount;
                            $transaction->charges = "";
                            $transaction->from_currency = $formCurrency;
                            $transaction->to_currency = $toCurrency;
                            $transaction->status = "0";
                            $transaction->created_at = Carbon::now();
                            $transaction->save();
                            event(new NewTransactionReceivedEvent($transaction));
                            if($toCurrency == "NGN" || $transaction->to_currency == "NGN"){
                                $this->ngnAutoTransfer($transaction->id,$transaction->transferAmount);
                            }
                            if($toCurrency == "PM" || $transaction->to_currency == "PM"){
                                $payer = BankDetail::where(['user_id'=>$id,'type_id'=>'2'])->first();
                                $string = 'eCurrency';
                                $string .= \Str::random(20);
                                $this->pmAutoTransfer($transaction->id,$transaction->transferAmount,$payer->account_no,$string);   
                            }
                            $request->session()->forget(['from_currency', 'to_currency','amount']); 
                            return redirect('/')->with('success','Bitcoin Payment successfully done.');
                        }
                    }
                }*/
            }
        }else{
            return response()->json(
                array(
                    'msg' => 'No transaction found',
                    'success' => '0'
                )
            );
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

    public function ngnAutoTransfer($id,$amount){
        $data = Transaction::where(['id'=>$id,'from_currency'=>'BTC','to_currency'=>'NGN','status'=>'0'])->with('user')->first();
        if(!empty($data)){
            $toType = Type::where('short_name',$data->to_currency)->first();
            $bankDetail = BankDetail::where(['user_id'=>$data['user']->id,'type_id'=>$toType->id])->first();
            $rate = $amount;
            $chkBalance = $this->balanceCheck($this->rubies->bank_account_no);
            if($chkBalance->responsecode == "00" && $chkBalance->balance > $rate && $rate <= $this->rubies->min_amount){
                $send = $this->sendAmount($rate,$bankDetail->account_no,$bankDetail->bank_code,$bankDetail->bank_name,$bankDetail->account_name,$chkBalance->accountname);
                if($send){
                    $transfer = new Transfer;
                    $transfer->user_id = $data['user']->id;
                    $transfer->type_id = $toType->id;
                    $transfer->transaction_id = $data->id;
                    $transfer->ref_no = $send->reference;
                    $transfer->draccount = $send->draccount;
                    $transfer->craccount = $send->craccount;
                    $transfer->amount = $send->amount;
                    $save = $transfer->save();
                    if($save){
                        $update = Transaction::where('id',$data->id)->update(['status'=>'1']);
                        event(new NewTransferSendEvent($transfer));
                        /*return response()->json(
                            array(
                                'msg' => 'Transaction successful.!',
                                'success'=>'1',
                                'is_admin' => Auth::user()->is_admin,
                            )
                        );*/
                    }else{
                        /*return response()->json(
                            array(
                                'msg' => 'Internal server error!',
                                'success'=>'0',
                                'is_admin' => Auth::user()->is_admin,
                            )
                        );*/
                    }
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

    public function pmAutoTransfer($id,$amount,$payer,$string){
        $userid = Auth::user()->id;
        $client = new \GuzzleHttp\Client();
        // $api = 'https://perfectmoney.com/acct/confirm.asp?AccountID=3908528&PassPhrase=12Durex@&Payer_Account=U9831864&Payee_Account=U9831864&Amount=0.001&PAYMENT_ID='..'';
        $api = 'https://perfectmoney.com/acct/confirm.asp?AccountID='.$this->pmConfs->bank_username.'&PassPhrase='.$this->pmConfs->bank_password.'&Payer_Account='.$this->pmConfs->bank_account_no.'&Payee_Account='.$payer.'&Amount='.$amount.'&PAYMENT_ID='.$string.'';
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
            return array('msg'=>'Invalid output','success'=>'0');
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
        $rave->user_id = $userid;
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
            $transfer->user_id = $userid;
            $transfer->type_id = "2";
            $transfer->transaction_id = $id;
            $transfer->draccount = $array['Payer_Account'];
            $transfer->craccount = $array['Payee_Account'];
            $transfer->ref_no = $array['PAYMENT_ID'];
            $transfer->amount = $array['PAYMENT_AMOUNT'];
            $tsave = $transfer->save();
            if($tsave){
                $transaction = Transaction::findOrFail($id);
                $transaction->status = "1";
                $transaction->updated_at = Carbon::now();
                $transaction->save();
                event(new NewTransferSendEvent($transfer));
            }
        }
        return array('msg'=>'Transfer successfully','success'=>'1','data'=>$array);
    }


}
