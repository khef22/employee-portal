<?php

namespace App\Http\Controllers\Auth;

use Auth;
use JWTAuth;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Config;
use GuzzleHttp;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'username'    => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username','password');
		
		if(list($user,$token) = $this->attempt($credentials)){
			return response()->success(compact('user', 'token'));
        }else{
			return response()->error('Invalid credentials', 401);
		}
		
    }

    public function google(Request $request)
    {

    	$google = new \App\Helper\GoogleLogin();

		if($profile = $google->get_email($request)){

	        if($user = User::where('email',trim($profile['email']))
				->where('active',1)->first()){

				$token = JWTAuth::fromUser($user);
				return response()->success(compact('user', 'token'));
			}else{
				return response()->error('Invalid credentials', 401);
			}

		}else{
			return response()->error('Check Google API Key', 401);
		}

    }

    public function unlink(Request $request)
    {
    	Auth::logout();
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'       => 'required|min:3',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:8',
        ]);

        $user = new User;
        $user->name = trim($request->name);
        $user->email = trim(strtolower($request->email));
        $user->password = bcrypt($request->password);
        $user->save();

        $token = JWTAuth::fromUser($user);

        return response()->success(compact('user', 'token'));
    }
	
	private function attempt(array $credentials = []){
		
		$pos = strpos($credentials['username'],"@zylun.com");	
		if($pos > 0){
			$credentials['username'] = str_replace("@zylun.com","",$credentials['username']);
		}
		
		if($user = User::where('username',trim($credentials['username']))
			->where('active',1)->first()){
			
			if(trim($credentials['password']) != "" && md5($credentials['password']) == $user->password){
				
				Auth::login($user);
				$token = JWTAuth::fromUser($user);
				
				return array($user,$token);
			}
			
		}
		
		return false;
	}
}
