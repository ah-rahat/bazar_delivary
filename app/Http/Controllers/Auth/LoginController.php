<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        if (auth()->check() && auth()->user()->isAdmin()) {
            $this->redirectTo = '/ad';
        } else {
            $this->redirectTo = '/pm';
        }
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function oldlogin(){

        return view('auth.mainoldlogin');
    }
    public function authenticate(Request $request)
    {

        $user = DB::table('users')
            ->join('otptokens', 'otptokens.phone', '=', 'users.phone')
            ->where('users.email', '=',  $request->email)
            ->where('otptokens.token', '=',  $request->otp_code)
            ->where('otptokens.id', '=',  $request->token_html)
            ->count();

        if($user == 1){
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                // Authentication passed...
                return redirect()->intended('/');
            }else{
                $request->session()->flash('status', 'Login Failed.');
                return redirect()->intended('/login');
            }
        }else{
            $request->session()->flash('status', 'Login Failed.');
            return redirect()->intended('/login');
        }
    }

//    protected function redirectTo( ) {
//        if (Auth::check() && Auth::user()->role == 'admin') {
//
//           return redirect('/');
//        }
//        elseif (Auth::check() && Auth::user()->role == 'vendor') {
//            return('/ve');
//        }
//        else {
//            return('/login');
//        }
//    }

}
