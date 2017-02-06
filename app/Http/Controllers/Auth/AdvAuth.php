<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class AdvAuth extends Controller
{
	public function auth(Request $request) {
		if (Auth::attempt(['login' => $request->input('login'), 'password' => $request->input('password'), 'confirmed' => 1, 'valid' => 1]))
		{
			return redirect('/home'); 
		} 
		else 
		{
			return back()->with('message','Неверные имя пользователя/пароль. Пользователь не активирован или заблокирован. Обратитесь к администратору.');
		}
	}
}
