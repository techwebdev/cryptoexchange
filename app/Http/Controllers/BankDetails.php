<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Crypt;
use App\BankDetail;
use App\User;
use Validator;


class BankDetails extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('IsVerfied');
    }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verify($type=null){
        return view('web.verify',compact('type'));
    }

    public function verifyAmount(Request $request){
        $validator = Validator::make($request->all(),[
            'amount' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput()->with('error',$validator->messages()->first());
        }
        // echo "<pre>";print_r(Type::find(1)->type);die;
        // echo "<pre>";print_r(BankDetail::find(Auth::user()->id)->with('type')->get()->toArray());die;
        $data = BankDetail::where(['user_id'=>Auth::user()->id,'sent_amount'=>$request->amount,'type_id'=>$request->type])->first();
        // echo "<pre>";print_r($data);die;
        if(!empty($data)){
            User::where('id',Auth::user()->id)->update(['isVerified'=>true]);
            BankDetail::where(['user_id'=>Auth::user()->id,'sent_amount'=>$request->amount,'type_id'=>$request->type])->update(['isVerified'=>true]);
            return redirect('home')->withInput()->with('success','You are successfully verfied.');
        }else{
            $attempt = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>$request->type])->first();
            if($attempt->isAttempt != 0){
                BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>$request->type])->update(['isAttempt'=>($attempt->isAttempt - 1)]);
                $maxAttempt = BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>$request->type])->first();
                if($maxAttempt->isAttempt == 0){
                    return redirect()->route('home')->with('error','You have reached max attempts your account is blocked');
                }else{
                    return redirect()->back()->withInput()->with('error','You have entered invalid amount.');   
                }
            }else{
                BankDetail::where(['user_id'=>Auth::user()->id,'type_id'=>$request->type])->update(['isAttempt'=>"0"]);
                return redirect()->route('home')->with('error','You have reached max attempts your account is blocked');
                /*Session::flush();
                Auth::logout();
                return redirect()->route('login')->withInput()->with('error','You have reached max attempts your account is blocked');*/
            }
        }
    }

}
