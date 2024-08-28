<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request){
           $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20',
            Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
           ]) ;

        //    $incomingFields['password'] = bcrypt($incomingFields['password']); you can either use
        // this or use the hashed one in the user.php model
           User::create($incomingFields);
           return 'you have entered to the log in screen';
    }

    public function login(Request $request){
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);
      if(auth()->attempt([
        'username' => $incomingFields['loginusername'],
        'password' =>$incomingFields['loginpassword']
      ])){
        $request->session()->regenerate();  //for setting the user session
        return 'congrats buddy!!!';
      }
      else{
        return'oops sorry dude';
      }
    }

    public function showCorrectHomePage(){
        if(auth()->check()){
       return view('homepage_feed');
        }

        else{
            return view('homepage');
        }
    }
}

