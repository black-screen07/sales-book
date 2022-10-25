<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }


    public function index()
    {
       //dd(Hash::make(''));

        return view('login');
    }


    public function login(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);
            //dd(Hash::make('123'));

        if (
            Auth::guard('user')->attempt(
            ['email' => $request->username,
            'password' => $request->password,
            'enabled' => 1],
            $request->get('rember'))
        )
        {
            return redirect()->intended('dashboard');
        }

        $request->session()->flash('ess-msg', "Echec d'authentification");
        return back()->withInput($request->only('username', 'rember'));
    }


    public function logout(Request $request){
        Auth::logout();

        return redirect('dashboard');
    }
}
