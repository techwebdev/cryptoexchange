<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use Illuminate\Http\Request;
use Validator;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ExchangeRate::all();
        return view('admin.exchange-rate.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.exchange-rate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'from_currency' => 'required',
           'to_currency' => 'required',
           'amount' => 'required|numeric'
        ],[
            'from_currency.required' => 'This currency field is required',
            'to_currency.required' => 'This currency field is required',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount should be in number'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = new ExchangeRate;
        $data->from_currency = strtoupper($request->from_currency);
        $data->to_currency = strtoupper($request->to_currency);
        $data->amount = $request->amount;
        $save = $data->save();
        if($save){
            return redirect()->route('admin.exchange-rate.index')->withInput()->with('success','Data saved successfully!');
        }else{
            return redirect()->route('admin.exchange-rate.index')->withInput()->with('error','Data not saved successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function show(ExchangeRate $exchangeRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function edit(ExchangeRate $exchangeRate)
    {
        return view('admin.exchange-rate.edit')->with('data',$exchangeRate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExchangeRate $exchangeRate)
    {
        $validator = Validator::make($request->all(), [
           'from_currency' => 'required',
           'to_currency' => 'required',
           'amount' => 'required|numeric',
           'calc_amount' => 'required|numeric'
        ],[
            'from_currency.required' => 'This currency field is required',
            'to_currency.required' => 'This currency field is required',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount should be in number',
            'calc_amount.required' => 'Calculated amount is required',
            'calc_amount.numeric' => 'Calculated amount should be number'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = ExchangeRate::find($exchangeRate->id);
        $data->from_currency = strtoupper($request->from_currency);
        $data->to_currency = strtoupper($request->to_currency);
        $data->amount = $request->amount;
        $data->calc_amount = $request->calc_amount;
        $update = $data->save();
        if($update){
            return redirect()->route('admin.exchange-rate.index')->withInput()->with('success','Data saved successfully!');
        }else{
            return redirect()->route('admin.exchange-rate.index')->withInput()->with('error','Data not saved successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExchangeRate $exchangeRate)
    {
        $data = ExchangeRate::findOrFail($exchangeRate->id);
        $delete = $data->delete();
        if($delete){
            return redirect()->back()->with('success', 'Data deleted sucessfully!');
        }else{
            return redirect()->back()->with('error', 'Data not deleted sucessfully!');
        }
    }
}
