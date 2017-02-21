<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Exception;
use Response;
use App\Users;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('home');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUsers()
    {
        $users = Users::paginate(config('app.users_on_page_admin'));
        Session::put('page', $users->currentPage());

        return view('layouts/admin/users', ['users' => $users, 'message'=>'']);
    }

    /**
     * Destroy a user instance after by valid user role.
     *
     * @param  integer  $id
     * @return string
     */
    public function destroyUser($id)
    {
        if (Auth::user()->role_id == 1) {
            $user = Users::findOrFail($id);
            $username = $user->username;
            try {
                $user->delete();
                return redirect()->back()->with('message', 'Пользователь '.$username.' удален');
            } catch (Exception $e) {
                return redirect()->back()->with('message', 'Невозможно удалить пользователя '.$username);
            }
        } else {
            return redirect()->back()->with('message', 'Недостаточно прав для удаления пользователя');
        }
    }

        /**
     * Confirm user registration in DB
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmUser(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $user = Users::findOrFail($request->input('user_id'));
            $user->confirmed = 1;
            $user->save();
            $data = array( 'text' => 'success' );
        } else {
            $data = array( 'text' => 'fail' );
        }
        return Response::json($data);
    }
    /**
     * Set in DB block field for user
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function blockUser(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $user = Users::findOrFail($request->input('user_id'));
            $user->valid = $request->input('action');
            $user->save();
            $data = array( 'text' => 'success' );
        } else {
            $data = array( 'text' => 'fail' . $request->input('action') );
        }
        return Response::json($data);
    }         
    /**
     * Grant user administrator rights in DB
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adminUser(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $user = Users::findOrFail($request->input('user_id'));
            //нельзя снять права админа с самого себя и юзера с id = 1
            if (!((Auth::user()->id == $user->id) || ($user->id == 1)))  {
                $user->role_id = $request->input('action');
                $user->save();
                $data = array( 'text' => 'success' );
            } else {
                $data = array( 'text' => 'fail' . $request->input('action') );
            }
        } else {
            $data = array( 'text' => 'fail' . $request->input('action') );
        }
        return Response::json($data);
    }     

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Users::find($id);

        return view('userEdit', ['user'=>$user]);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Users::find($id);
        $userlogin = $user->login;
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'name' => 'required|max:250',
            'dopname' => 'max:80',
            'phone' => 'required|max:60',
            'pay_till' => 'date|nullable',
        ]); 
        $form = $request->all();
        $user->update($form);

        if (Auth::user()->role_id == 1) {
            return redirect('/admin/users?page=' . Session::get('page',1))->with('message','Данные пользователя ' . $userlogin . ' обновлены успешно.');
        }
        else
        {
            return redirect('home')->with('message','Данные пользователя обновлены успешно.'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
