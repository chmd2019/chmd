<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{

    public function username(){
        return 'usuario';
    }

   public function login(){
    $credentials = $this->validate(request(),[
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

    if(Auth::attempt($credentials)){
        return redirect()->route('dashboard');
    }
    return "Error";

   }    
}
