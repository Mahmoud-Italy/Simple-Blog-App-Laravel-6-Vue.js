<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\User;
use Auth;

class AuthCtrl extends Controller
{
    public function signup(Request $request)
    {
    	if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) { 
        	return self::respondValidationError('Invalid Email Address.');
        } 

        if (User::where('email', $request->email)->count()) { 
        	return self::respondValidationError('Email Address already exists.');
        }

        else {
            try {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->ip_address = \Request::ip();
                $user->user_agent = $request->server('HTTP_USER_AGENT');
                $user->bcrypt_key = uniqid(time());
                $user->save();

                #Send Mail for Verifiy Account
                Mail::send('emails.verify', ['user' => $user], function($message) use($user) {
                    $message->to($user->email, $user->name)->subject('Thanks for signing up, '.$user->name);
                });

            	return self::respondCreated();

            } catch (\Exception $e) { 
            	return self::respondSomethingWrong('Something went wrong.'.$e);
            }	
        }
    }


    public function verify(Request $request)
    {
        if(!$request->key) {
            return self::respondValidationError('Activation key is required.');
        }

        $row = User::verifyAccount($request->key);
        if($row) {
            $accessToken = $row->createToken('myApp')->accessToken; 
            $data = ['accessToken'=>$accessToken,'username'=>$row->name,'is_author'=>$row->is_author,'is_admin'=>$row->is_admin];
            return self::respondSuccess($data);
        }

        return self::respondSomethingWrong('Invalid Activation key.');
    }



    public function login(Request $request)
    {
    	$credentials = ['email'=>$request->email, 'password'=>$request->password];
        if (Auth::attempt($credentials, true)) { 
        	$user = Auth::user(); 
            if(!$user->status) {
                return self::respondValidationError('Account not activated.');
            } else {
                $success['token'] = $user->createToken('myApp')->accessToken; 
                $data = ['accessToken'=>$success['token'],'username'=>$user->name,'is_author'=>$user->is_author,'is_admin'=>$user->is_admin];
                return self::respondSuccess($data);
            }
        }
        
        return self::respondValidationError('Unauthorised Credentials.');
    }


    public function forgot(Request $request)
    {
    	if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) { 
            return self::respondValidationError('Invalid Email Address.');
        } 

        if (!User::where('email', $request->email)->count()) { 
            return self::respondValidationError('Email Address not exists.');
        }

        $user = User::where('email', $request->email)->first();
        $user->bcrypt_key = uniqid(time());
        $user->save();

            #Send Mail for Verifiy Account
            Mail::send('emails.forgot', ['user' => $user], function($message) use($user) {
                $message->to($user->email, $user->name)->subject('You recently requested to reset your password, '.$user->name);
            });

         return self::respondSuccess();
    }

    public function reset(Request $request)
    {
    	if (!User::where('bcrypt_key', $request->key)->count()) { 
            return self::respondValidationError('Invalid forgot key.');
        }

        if ($request->new_password != $request->confirm_password) { 
            return self::respondValidationError('Passwords not match.');
        }

        $user = User::where('bcrypt_key', $request->key)->first();
        $user->bcrypt_key = NULL;
        $user->password = bcrypt($request->new_password);
        $user->save();

            #Send Mail for Verifiy Account
            Mail::send('emails.reset', ['user' => $user], function($message) use($user) {
                $message->to($user->email, $user->name)->subject('Your password was changed successfully, '.$user->name);
            });

        return self::respondSuccess();
    }

}
