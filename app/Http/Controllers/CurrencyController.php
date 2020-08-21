<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Currency::orderBy('id','desc')->get()->toArray();
        return view('admin.currency.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.currency.create');
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
           'name' => 'required',
           'value' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error',$validator->messages()->first());
        }
        $data = new Currency();
        $data->name = strtoupper($request->name);
        $data->value = $request->value;
        $data->save();
        return redirect()->route('admin.currency.index')->withInput()->with('success','Data saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view('admin.currency.edit')->with('data',$currency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        // print_r($currency->toArray());die;
        // $data = Currency::findOrFail();
        $validator = Validator::make($request->all(), [
           'name' => 'required',
           'value' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error',$validator->messages()->first());
       }
       $data = new Currency;
       $data->name = strtoupper($request->name);
       $data->value = $request->value;
       Currency::where('id',$currency->id)->update($data->toArray());
       return redirect()->route('admin.currency.index')->withInput()->with('success','Data saved successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $data = Currency::findOrFail($currency->id);
        $delete = $data->delete();
        if($delete){
            return redirect()->back()->with('success', 'Data deleted sucessfully!');
        }else{
            return redirect()->back()->with('error', 'Data not deleted sucessfully!');
        }
    }
}
