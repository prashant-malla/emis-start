<?php

namespace App\Http\Controllers\SuperAdmin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
     * @throws ValidationException
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::SUPER_ADMIN_HOME;
    
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|exists:users,' . $this->username(),
            'password' => 'required',
        ], [
            $this->username() . '.exists' => 'Invalid Login Credentials.'
        ]);
    }

    // protected function authenticated(Request $request, $user)
    // {
    //     if(Auth::check()) {
    //         if($user->role == 'superadmin') {
    //             return redirect()->route('dashboard');
    //         }
    //         elseif($user->role == 'admin') {
    //             return redirect()->route('admin.dashboard');
    //         }
    //     }
    //     else{
    //         return view('auth.login');
    //     }
    // }

    protected function authenticated(Request $request, $user)
    {
        Auth::guard('staff')?->logout();
    }

    public function guard(){
        return Auth::guard('web');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
