<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest'])->except('logout');
    }

    /* protected function credentials(Request $request) {
		return array_merge($request->only($this->username(), 'password'), ['isVerified' => '1']);
	} */

    public function login(Request $request)
    {   
        $input = $request->all();
   
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
            // return redirect()->back()->withInput()->with('error',$validator->messages()->first());
        }
   
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if(auth()->user()->isVerified != "1"){
                auth()->logout();
                return redirect()->route('login')
                ->with('error','Please verify email first.');
            }else{
                if (auth()->user()->is_admin == 1) {
                    return redirect()->route('admin.home');
                }else {
                    if(session('previousURL') != ""){   
                        if(auth()->user()->email_verified_at != ""){
                            return redirect(session('previousURL'));
                            session::forget('previousURL');
                        }else{
                            redirect('email/verify')->with('error','Please verify the email first.!');
                            /* return redirect(session('previousURL'));
                            session::forget('previousURL'); */
                        }
                    }
                    return redirect('/');
                }
            }
        }else{
            return redirect()->route('login')
                ->with('error','Email or password are invalid.');
        }
          
    }
}
