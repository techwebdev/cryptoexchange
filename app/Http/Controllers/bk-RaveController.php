<?php

namespace App\Http\Controllers;

// use App\Rave;
use Illuminate\Http\Request;
use App\Events\NewTransactionReceivedEvent;
use App\Events\NewTransferSendEvent;
use Rave;
use Crypt;
use Auth;
use App\Transaction;
use App\ExchangeRate;
use App\BankDetail;
use App\Raves;
use App\Settings;
use App\Transfer;
use Session;
use Carbon;

class RaveController extends Controller
{
    protected $Amount;
    protected $fromCurrency;
    protected $toCurrency;
    protected $Status;
    protected $pmConfs;
    protected $btcConfs;

    public function __construct(Request $request){
        $this->pmConfs = Settings::where('type_id','2')->first();
        $this->btcConfs = Settings::where('type_id','3')->first();
        $this->Amount = $request->amount;
        $this->fromCurrency = $request->from_currency;
        $this->toCurrency = $request->to_currency;
        $this->Status = $request->status;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amount = Crypt::decrypt($this->Amount);
        $from_currency = Crypt::decrypt($this->fromCurrency);
        $to_currency = Crypt::decrypt($this->toCurrency);
        $status = Crypt::decrypt($this->Status);
        Session::put('to_currency', $to_currency);
        return view('rave.index')->with(['amount'=>$amount,'from_currency'=>$from_currency,'to_currency'=>$to_currency,'status'=>$status]);
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
     * @param  \App\Rave  $rave
     * @return \Illuminate\Http\Response
     */
    public function show(Rave $rave)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rave  $rave
     * @return \Illuminate\Http\Response
     */
    public function edit(Rave $rave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rave  $rave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rave $rave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rave  $rave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rave $rave)
    {
        //
    }

    public function initialize(Request $request)
  	{
    	//This initializes payment and redirects to the payment gateway
    	//The initialize method takes the parameter of the redirect URL
        switch ($request->method()) {
            case 'POST':
                Rave::initialize(route('callback'));
            break;

            case 'GET':
                return redirect('/')->with('error','Transaction cancelled..!!');
            break;
        }
    	// Rave::initialize(route('callback'));
  	} 

    public function callback(Request $request){
        $obj = json_decode($request->resp,true);
        // echo "<pre>";print_r($obj);die;
        if(!empty($obj)){
            $txnId = $obj['tx']['id'];
            $txRef = $obj['tx']['txRef'];
            $flwRef = $obj['tx']['flwRef'];
            $status = $obj['tx']['status'];
            if($txRef != "" && $txnId != ""){
                $verify = Rave::verifyTransaction($txRef);
                // echo "<pre>";print_r($verify);die;
                $currency = "NGN";
                $data = $verify->data;
                $chargeResponsecode = $data->chargecode;
                $chargeFee = $data->appfee;
                $chargeAmount = $data->amount + $chargeFee;
                $amount = $data->chargedamount;
                $chargeCurrency = $data->currency;
                $rave = new Raves;
                $rave->user_id = Auth::user()->id;
                $rave->txn_id =  $txnId;
                $rave->txn_Ref =  $txRef;
                $rave->txn_flwRef =  $flwRef;
                $rave->currency = $chargeCurrency; 
                $rave->amount =  $data->amount;
                $rave->charges =  $chargeFee;
                $rave->txn_status = $status === "successful" ? "1" : "0";
                $rave->save();
                if(($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)){
                    $transferAmount = ExchangeRate::where(['from_currency'=>$chargeCurrency,'to_currency'=>Session::get('to_currency')])->first();
                    $transaction = new Transaction;
                    $transaction->user_id = Auth::user()->id;
                    $transaction->rave_id = $rave->id;
                    $transaction->amount = $chargeAmount;
                    $transaction->transferAmount = $transferAmount->amount * $data->amount;
                    $transaction->charges = $chargeFee;
                    $transaction->from_currency = $chargeCurrency;
                    $transaction->to_currency = Session::get('to_currency');
                    $transaction->status = "0";
                    $transaction->created_at = date('Y-m-d h:i:s');
                    $save = $transaction->save();
                    if($save){
                        event(new NewTransactionReceivedEvent($transaction));
                        if(Session::get('to_currency') == "PM" || $transaction->to_currency == "PM"){
                            $payer = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>'2'])->first();
                            $string = 'eCurrency';
                            $string .= \Str::random(20);
                            $autoTransfer = $this->pmAutoTransfer($transaction->id,$transaction->transferAmount,$payer->account_no,$string);
                        }
                        if(Session::get('to_currency') == "BTC"|| $transaction->to_currency == "BTC"){
                            $toAddress = BankDetail::where('type_id','3')->first();
                            $fromAddress = $this->btcConfs->account_no;
                            $autoTransfer = $this->btcAutoTransfer($transaction->id,$transaction->transferAmount,$fromAddress,$toAddress->account_no);
                        }
                        $request->session()->forget(['from_currency', 'to_currency','amount']);
                        return redirect('/')->with('success','Payment successful.Transaction exchange request has been proccess successfully');
                    }else{
                        return redirect('/')->with('error','Error in transaction exchange request');
                    }   
                }else{
                    return redirect('/')->with('error','Error in payment.Transaction exchange request has not been proccess successfully');
                }
            }else{
                return redirect('/')->with('error', 'Transaction Failed No Reference');   
            }
        }else{
            return redirect('/')->with('error', 'There is an internal server error');   
        }

    }

    public function btcAutoTransfer($transactionID,$amount,$from,$to){
        $amount = $amount / 100000000;
        $client = new \GuzzleHttp\Client();
        $api = 'http://97a9be172116.ngrok.io/merchant/'.$this->btcConfs->btc_address.'/payment?password=Shreeji@1&to='.$to.'&amount='.$amount.'';
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

    public function raveBTC(Request $request){
        switch ($request->method()) {
            case 'POST':
                // echo "<pre>";print_r($this->btcConfs);die;
                $amount = $request->amount;
                $beed_notify = TRUE;
                $beed_sound_code = "data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=";
                $appSecretKey = $this->btcConfs->app_secret_key;
                $secretKey = $this->btcConfs->secret_key;
                $xpubKey = $this->btcConfs->pub_key;
                $btcConfs = $this->btcConfs;
                $orderID = uniqid();
                $app_webSocketURL = "wss://ws.blockchain.info/inv";
                $gap = $this->gapLimit();
                // $app_callback_url = 'http://cryptoexchnage.herokuapp.com/callback.php?invoice='.$orderID.'&secret='.$appSecretKey.'';
                $sendBox = false;
                if($sendBox){
                    $app_callback_url = 'http://cryptoexchnage.herokuapp.com/callback.php?confirmations=1&invoice='.$orderID.'&secret='.$appSecretKey.'';
                }else{
                    $app_callback_url = route('btcCallback',['invoice'=>$orderID,'secret'=>$appSecretKey,'value'=>$amount,'confirmations'=>'1']);
                }
                // echo $app_callback_url;die;
                return view('rave.btc',compact('app_callback_url','orderID','app_webSocketURL','xpubKey','secretKey','amount','beed_notify','beed_sound_code','btcConfs','gap'));
            break;

            case 'GET':
                session()->forget(['from_currency','to_currency','amount']);
                return redirect('/')->with('error','You payment has cancelled');
            break;
        }
        // $satoshi_amount = ($request->amount / 100000000);
        /* $bitcoin_wallet_id = $request->bitcoin_wallet;
        $bitcoin_address_id = $request->bitcoin_address;
        $bitcoin_password = $request->bitcoin_password;
        $bitcoin_second_password = $request->bitcoin_second_password;
        $amount = $request->amount;
        $to_address = $request->to_address;

        if($amount != "" && $bitcoin_wallet_id != "" && $bitcoin_address_id != "" && $bitcoin_password != "" && $to_address != ""){
            $client = new \GuzzleHttp\Client();
            // $api = 'https://blockchain.info/merchant/'.$bitcoin_wallet_id.'/payment?password="'.$bitcoin_password.'"&second_password="'.$bitcoin_second_password.'"&to="'.$to_address.'"&amount="'.$amount.'"';
            // $api = 'https://blockchain.info/merchant/d54e3c0b-894f-4ad3-9103-56d5607c2734/payment?password="Web@squad2020"&second_password=""&to=""&amount="0.00000000000000001"';
            $api = 'https://api.blockchain.info/v2/receive/balance_update';
            $body = array(
                'address' => 'd54e3c0b-894f-4ad3-9103-56d5607c2734',
                'callback' => route('btcCallback'),
                'key' => '51a8b9d6-776e-480f-b8be-6dad3fb4e687',
                'onNotification' => 'KEEP'
            );
            $res = $client->post($api,$body);
            echo $res->getStatusCode();die; // 200
            echo "<pre>";print_r($res->getBody());die;
            print_r($api);die;
        } */
    }

    public function gapLimit(){
        $api = 'https://api.blockchain.info/v2/receive/checkgap?xpub='.$this->btcConfs->pub_key.'&key='.$this->btcConfs->secret_key.'';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET',$api);
        $result = $response->getBody()->getContents();
        $result = json_decode($result);
        return $result;
    }

    public function btcCallback(Request $request){
        $invoice = $request->invoice;
        $secret = $request->secret;
        $confirmations = $request->confirmations;
        if($secret != $this->btcConfs->app_secret_key){
            die('APIKEY secret does not match the original on which was created.');
        }else{
            $order_num = $invoice;
            $amount = $_GET['value']; //default value is in satoshis
            $confirmations = $_GET["confirmations"];

            $_SESSION['pay_address_ispaid'] = TRUE;//this can be read from the Database
            $fff = fopen("response_".$invoice.".txt","w");
            $fw = fwrite($fff, json_encode($_GET));
            fclose($fff);  //
            echo "*ok*"; // you must echo *ok* on the page or blockchain will keep sending callback requests every block up to 1,000 times!
        }
    }

    public function pendingBTC(Request $request){
        $amount = Crypt::decryptString($request->amount);
        $payTo = Crypt::decryptString($request->address);
        if($amount != "" && $payTo != ""){
            $beed_notify = TRUE;
                $beed_sound_code = "data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=";
            $secretKey = $this->btcConfs->secret_key;
            $xpubKey = $this->btcConfs->pub_key;
            $appSecretKey = $this->btcConfs->app_secret_key;
            $orderID = uniqid();
            $gap = $this->gapLimit();
            $app_webSocketURL = "wss://ws.blockchain.info/inv";
            $app_callback_url = 'http://cryptoexchnage.herokuapp.com/callback.php?invoice='.$orderID.'&secret='.$appSecretKey.'';
            return view('web.btc',compact('amount','payTo','secretKey','xpubKey','app_callback_url','gap','orderID','app_webSocketURL','beed_notify','beed_sound_code'));
        }
    }

    public function pmAutoTransfer($id,$amount,$payer,$string){
        /********Check balance before********/  
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
        $rave->user_id = Auth::user()->id;
        $rave->txn_id =  $array['PAYMENT_BATCH_NUM'];
        $rave->txn_Ref =  $array['PAYMENT_ID'];
        $rave->txn_flwRef =  "";
        $rave->currency = "PM"; //dynamic
        $rave->amount =  abs($array['PAYMENT_AMOUNT']);
        $rave->charges =  "";
        $rave->txn_status = "1";
        $save = $rave->save();
        if($save){
            $transfer = new Transfer;
            $transfer->user_id = Auth::user()->id;
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
