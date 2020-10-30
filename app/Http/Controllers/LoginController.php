<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

	protected function validateLogin(Request $request)
	{
	    $this->validate($request, [
	        $this->email() => 'exists:users,' . $this->email() . '',
	        'password' => 'required|string',
	    ]);
	}
}
