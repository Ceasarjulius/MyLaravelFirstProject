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
         $user =  User::create($incomingFields);//temporarly store the user details and pass them directly
         auth()->login($user);  //this will pass on the cookies of the user and allow him to be loged in directly
           return redirect('/')->with('success', 'you have registered an account succesfully');
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
        return redirect('/')->with('success', 'you have succesfully loged in');
      }
      else{
        return redirect('/')->with('failure', 'Incorrect log in credentials');
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

    public function logout(){
        auth()->logout();
        return redirect('/')->with('success', 'you have succesfully loged out');
    }
}

