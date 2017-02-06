<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'login' => 'required|max:30|unique:users',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
            'name' => 'required|max:250',
            'dopname' => 'max:80',
            'phone' => 'required|max:60',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $confirmation_code = str_random(32);
        
        $data['link'] = '/register/confirm/' . $confirmation_code;
        
        /*
        Mail::send('layouts.mailconfirm', $data, function ($message) use ($data) {
                $message->to($data['email'])
                    ->subject('Confirm registration ' . $data['login']);
            });
        */

        return User::create([
            'login' => $data['login'],
            'email' => $data['email'],
            'name' => $data['name'],
            'dopname' => $data['dopname'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => $confirmation_code,
        ]);
    }
}
