<?php

namespace App\Http\Controllers;

use App\BitcoinPayment;
use Illuminate\Http\Request;
use App\Raves;
use App\Transaction;

class BitcoinPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\BitcoinPayment  $bitcoinPayment
     * @return \Illuminate\Http\Response
     */
    public function show(BitcoinPayment $bitcoinPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BitcoinPayment  $bitcoinPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(BitcoinPayment $bitcoinPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BitcoinPayment  $bitcoinPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BitcoinPayment $bitcoinPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BitcoinPayment  $bitcoinPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BitcoinPayment $bitcoinPayment,$id)
    {
        $data = BitcoinPayment::find($id);
        $delete = $data->delete();
        if($data){
            $rave = Raves::where('bitcoin_id',$id)->first();
            $delete = $rave->delete();
            $transaction = Transaction::where('rave_id',$rave->id)->delete();
            return redirect()->back()->with('success', 'Your transaction successfully cancelled.');
        }else{
            return redirect()->back()->with('error', 'Error in transaction cancelled.');
        }
    }
}
