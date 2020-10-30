<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function __construct()
    {
    	$this->user = new User();
    }

    public function store(Request $request)
    {
    	$data = $request->all();
    	$data['name'] = ucfirst($data['first_name']).' '.ucfirst($data['last_name']);
    	$response = $this->user->createUser($data);
    	if ($response) {
    		return Redirect('/'); 
    	}
    	return view('/');
    }

    public function show(Request $request)
    {
    	$email = $request->inputEmailAddress;
    	if (Auth::attempt(['email' => $email, 'password' => $request->inputPassword])){
    		return Redirect('/'); 
        }
    	return redirect()->back();
    }

    public function logout(Request $request) {
  		Auth::logout();
		return redirect('/login');
	}

	/**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($service)
    {
        $user = Socialite::driver($service)->user();
        $userDetails = $this->user->getUserDetails($user->getEmail());
        
        if ($userDetails == 0) {
        	$data['email'] = $user->getEmail();
        	$data['name'] = $user->getName();
        	$data['password'] = '123456';
        	$response = $this->user->createUser($data);
	    	if ($response) {
	    		return Redirect('/'); 
	    	}
        } else {
			return redirect('/login');
        }
    }
}
