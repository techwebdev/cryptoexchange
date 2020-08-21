<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Events\NewTransactionReceivedEvent;
use App\Events\NewTransferSendEvent;
use App\BitcoinPayment;
use App\Transaction;
use App\BankDetail;
use App\Transfer;
use App\Raves;
use App\Type;
use Carbon;

class CheckPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:btc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Payement Receive or not.!';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $confirm,$pmConfs,$rubies;

    public function __construct()
    {
        parent::__construct();
        $this->confirm = 3;        
        $this->pmConfs = \App\Settings::where('type_id','2')->first();
        $this->rubies = \App\Settings::where('type_id','4')->first();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info("Cron is Working fine");
        $payments = BitcoinPayment::where('status','0')->get();
        // \Log::info($payments);
    	// echo "<pre>";print_r($payments);die;
    	if(!empty($payments)){
    		foreach($payments as $val){
    		    if($val->status == "0"){
                    $confirmation = $this->checkConfirmation($val->from_address);
                    // \Log::info("Confirmation ".$confirmation);
                    if(!empty($confirmation) && $confirmation != ""){
                        $confirmIndex = $confirmation->confirmations;
                        if($confirmIndex >= $this->confirm){
                            $this->chk_n_insert($val->from_address,$confirmation);
                            if($val->receive_amount >= $val->actual_amount){
        	    				$update = BitcoinPayment::where('id',$val->id)->update(['status'=>'1']);
                                $update = Raves::where('bitcoin_id',$val->id)->update(['txn_status'=>'1']);
                                $file = 'archive-list-'.Carbon::today()->format('d-m-Y').'.csv';
                                $chkFile = \DB::table('files')->where('name',[$file])->first();
                                if(empty($chkFile)){
                                    \DB::table('files')->insert(['name'=>$file,'created_at'=>Carbon::now()]);
                                }
                                // dd(file_exists($file));
                                if(\File::exists($file)){
                                    // echo "update";die;
                                    // File::makeDirectory($backupLoc, 0755, true, true);
                                    // \Storage::put($file,$val->from_address, 'public');
                                    Storage::disk('public')->put($file, $val->from_address);
                                }else{
                                    // echo "insert";die;
                                    Storage::disk('public')->append($file, $val->from_address);
                                    \DB::table('files')->where('name',[$file])->update(['name'=>$file,'updated_at'=>Carbon::now()]);
                                }
                                // $delete = BitcoinPayment::where('id',$val->id)->delete();
                                \Log::info("Status Change successfully of address ".$val->from_address);
        	    			}else{
                                $update = BitcoinPayment::where('id',$val->id)->update(['status'=>'0']);
                                // \Log::info("Status not change successfully of address ".$val->from_address);
        	    			}
                        }
                        else{
                            $btc = BitcoinPayment::find($val->id);
                            $btc->unspent_status = "0";
                            $btc->save();
                        }
                    }else{
                        /********After 24 hours no recevie confirmation thn deletion********/
                        \Log::info("THis is Else Part");
                        $now = Carbon::now();
        				$to = Carbon::parse($val->created_at)->format('Y-m-d H:i:s');
        				$diff = $now->diffInHours($to);
        				// $diff = $now->diffInMinutes($to);
        				if($diff > 24){
        				    $data = BitcoinPayment::find($val->id);
                            $delete = $data->delete();
                            if($data){
                                $rave = Raves::where('bitcoin_id',$val->id)->first();
                                $delete = $rave->delete();
                                $transaction = Transaction::where('rave_id',$rave->id)->delete();
                            }
                            \Log::info("Address deleted successfully ". $val->id);
        				}
                    }
    			}
    		}
    	}

        $this->info('Payement Cron Cummand Run successfully!');
    }
    
    /*public function convert_number($amount){
        $first = 0;
        $string = (string) $amount;
        $precetion = explode("E",$string);
        if($precetion != "" && !empty($precetion)){
            $dot = explode(".",$precetion[0]);
            if(isset($dot[1]) && $dot[1] != 0){
              $dot = strlen($dot[1]);    
            }else{
              $dot = 0;    
            }
            //print_r(strlen($dot[1]));
            $first = explode("-",$precetion[1]);
            $first = $dot + $first[1];
            //print_r($first);
        }
        //echo $first;
        $float  = number_format($string,$first);
        return $float;
        //echo $float."<br>";
    }*/
    
    public function convert_number($amount){
        $first = 0;
        $string = (string) $amount;
        $precetion = explode("E",$string);
        if($precetion != "" && !empty($precetion)){
            $dot = explode(".",$precetion[0]);
            if(isset($dot[1]) && $dot[1] != "" && $dot[1] != 0){
              $dot = strlen($dot[1]);
            }else{
              $dot = 0;    
            }
            //print_r(strlen($dot[1]));
            if(isset($precetion[1])){
                $first = explode("-",$precetion[1]);
                $first = $dot + $first[1];   
            }else{
                $first = $dot;
            }
            //print_r($first);die;
        }
        //echo $first;
        $float  = number_format($string,$first);
        // echo $float;die;
        return $float;
        //echo $float."<br>";
    }
    
    public function chk_n_insert($fromAddress,$confirmation){
        // echo $fromAddress;die;
        $bitcoin = \App\BitcoinPayment::where('from_address',$fromAddress)->first();
        // print_r($bitcoin);die;
        $toAddress = $this->getUserAddress($fromAddress);
        $txHash = $confirmation->tx_hash;
        $script = $confirmation->script;
        \Log::info("Api Confirmation Amount ". $confirmation->value);
        // $apiAmount = (string)$confirmation->value;
        $amount = $confirmation->value / 100000000;
        $amount = $this->convert_number($amount);
        \Log::info("Confirmation Amount ". $amount);
        if(!empty($bitcoin) && $toAddress != "" && $txHash != "" && $script != "" && $amount != ""){
            $bitcoin->to_address = $toAddress;
            $bitcoin->receive_amount = $amount;
            $bitcoin->status = ($amount >= $bitcoin->amount) ? "1" : "0";
            $bitcoin->unspent_status = "1";
            $bitcoin->updated_at = \Carbon::now();
            $update = $bitcoin->save();
            if($update){
                $rave = Raves::where(['user_id'=>$bitcoin->user_id,'bitcoin_id'=>$bitcoin->id,'txn_status'=>'0'])->first();
                if(!empty($rave)){
                    $rave->txn_id = $script;
                    $rave->txn_Ref = $txHash;
                    $rave->currency = "BTC";
                    $rave->amount = $amount;
                    $rave->charges = "0";
                    $rave->txn_status = ($amount >= $bitcoin->amount) ? "1" : "0";
                    $rave->updated_at = \Carbon::now();
                    $save = $rave->save();
                    if($save){
                        $transaction = Transaction::where(['user_id'=>$bitcoin->user_id,'rave_id'=>$rave->id,'status'=>'0'])->first();
                        if(!empty($transaction)){
                            $transaction->amount = $amount;
                            $transaction->charges = "0";
                            $transaction->status = "0";
                            $transaction->updated_at = Carbon::now();
                            $transaction->save();
                            
                            event(new NewTransactionReceivedEvent($transaction));
                            if($transaction->to_currency == "NGN"){
                                \Log::info("AYvu NGN ma");
                                $this->ngnAutoTransfer($transaction->id,$transaction->transferAmount,$transaction->from_currency,$transaction->to_currency);
                            }
                            if($transaction->to_currency == "PM"){
                                \Log::info("AYvu PM ma");
                                $payer = \App\BankDetail::where(['user_id'=>$transaction->user_id,'type_id'=>'2'])->first();
                                $string = 'eCurrency';
                                $string .= \Str::random(20);
                                $this->pmAutoTransfer($transaction->id,$transaction->user_id,$transaction->transferAmount,$payer->account_no,$string,$transaction->to_currency);
                            }
                        }
                    }
                }
            }
            // echo "<pre>";print_r($confirmation);die;
        }
    }


    /*********PM Auto Transfer*************/
    public function pmAutoTransfer($id,$userid,$amount,$payer,$string,$tranferCurrency){
        if($amount <= $this->pmConfs->min_amount){
            $userid = Auth::user()->id;
            $client = new \GuzzleHttp\Client();
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
            $rave->currency = $tranferCurrency; //dynamic
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
                    $transaction = Transaction::find($id);
                    $transaction->status = "1";
                    $transaction->updated_at = Carbon::now();
                    $transaction->save();
                    event(new NewTransferSendEvent($transfer));
                }
            }
            return array('msg'=>'Transfer successfully','success'=>'1','data'=>$array);
        }
    }
    /**************************************/

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

    /***********NGN auto transfer**********/
    public function ngnAutoTransfer($id,$amount,$transactionCurrency,$transferCurrency){
        \Log::info("Log data");
        $data = Transaction::where(['id'=>$id,'from_currency'=>$transactionCurrency,'to_currency'=>$transferCurrency,'status'=>'0'])->with('user')->first();
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
                    $tsave = $transfer->save();
                    if($tsave){
                        $update = Transaction::where('id',$data->id)->update(['status'=>'1']);
                        event(new NewTransferSendEvent($transfer));
                    }
                }
            }
        }
    }  
    /*************************************/

    /***************Get User Address***************/
    public function getUserAddress($address){
        $client = new \GuzzleHttp\Client();
        $api = 'https://blockchain.info/rawaddr/'.$address.'';//$address
        $response = $client->request('GET',$api);
        $statusCode = $response->getStatusCode();
        $result = json_decode($response->getBody()->getContents());
        if(!empty($result->txs)){
            return $result->txs[0]->inputs[0]->prev_out->addr;
            // return $result;
        }else{
            return null;
        }
        // echo "<pre>";print_r($result->txs[0]->inputs[0]->prev_out->addr);die;
    }

    /**********Check Confirmation or not***********/
    public function checkConfirmation($address){
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
        return $result;
    }
}
