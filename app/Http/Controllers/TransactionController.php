<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $data = Transaction::orderBy('id','desc')->with('user')->with('rave')->get();
        // echo "<pre>";print_r($data);die;
        return view('admin.transaction.index')->with('data',$data);
        // return response()->json($data);
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
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        if($request->status == "success"){
            if($transaction->status == 0){
                $res = Transaction::find($transaction->id)->update(['status'=>'1']);
                if($res){
                    return response()->json(
                        array(
                            'result' => $res,
                            'msg' => 'Status has been successfully approved',
                            'success' => '1',
                        )
                    );
                }else{
                    return response()->json(
                        array(
                            'result' => $res,
                            'msg' => 'Status has not been successfully changed',
                            'success' => '0',
                        )
                    );
                }
            }
        }else{
            $res = Transaction::find($transaction->id)->update(['status'=>'2']);
            if($res){
                return response()->json(
                    array(
                        'result' => $res,
                        'msg' => 'Status has been successfully rejected',
                        'success' => '0',
                    )
                );
            }else{
                return response()->json(
                    array(
                        'result' => $res,
                        'msg' => 'Something went wrong',
                        'success' => '0',
                    )
                );
            }
        }
        // echo $transaction->id;die;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $data = Transaction::findOrFail($transaction->id);
        $delete = $data->delete();
        if($delete){
            return redirect()->back()->with('success', 'Data deleted sucessfully!');
        }else{
            return redirect()->back()->with('error', 'Data not deleted sucessfully!');
        }
    }
}
