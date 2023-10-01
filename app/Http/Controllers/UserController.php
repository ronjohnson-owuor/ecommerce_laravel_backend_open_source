<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Expr\Cast\Object_;

class UserController extends Controller
{
    public function signup(Request $request){
        try {
            $details = $request -> validate([
                'fullname' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'phone_number' => 'required',
                'location' => 'required'
            ]);
        } catch (ValidationException $ex){
            return response() ->json([
                "message" => $ex->errors()
            ]);
        }
        
        $protected_password = bcrypt($details['password']);
        $user = User::create([
            'name' => $details['fullname'],
            'email' =>  $details['email'],
            'password' => $protected_password,
            'phone' => $details['phone_number'],
            'location' => $details['location']
        ]);
        

        $user_token = $user -> createToken('user')->plainTextToken;
        return response() -> json([
            'message'=>"sign up successfull",
            'token' => $user_token
        ]);
        
    }
        
    
    public function login(Request $request){
        
        try{
            
            $details = $request -> validate([
                'email' => 'required',
                'password' => 'required',
            ]);  
        } catch (ValidationException $ex){
            return response() ->json([
                "message" => $ex->errors()
            ]);
        }
        
        $user = User::where('email', $details['email'])->first();
        $password_correct = Hash::check($details['password'], $user->password);
        if(!$user && !$password_correct){
            return response() -> json([
                "message" => "unable to login",
            ]);
        }
        
        $login_token = $user -> createToken('user') ->plainTextToken;
        return response() -> json([
            "message" => "login succesfull",
            "token" => $login_token
        ]); 
    }
    
    
    public function report(Request $request){
        try{
            $request ->validate([
                "problem" => 'required'
            ]);
        }catch(ValidationException $exe){
            return response() -> json([
                'message' => "an error occured"
            ]);
        }
        $user =  Auth::user();
        Report::create([
            'phone' => $user->phone,
            'email' => $user ->email,
            'problem' => $request->problem
        ]);
        return response() -> json([
            'message' => "report submitted"
        ]);
    }
    
    
    public function addmessage(Request $request){
        $user = Auth::user();
        Message::create([
            "name" => $user->name,
            "email" => $user->email,
            "phone" =>$user->phone,
            "message" => $request->message
        ]);
        
        return response() ->json([
            "message" => "message submitted"
        ]);
    }
    
}
