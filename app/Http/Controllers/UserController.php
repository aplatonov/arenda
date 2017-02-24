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
use File;

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
    public function showUsers(Request $request)
    {
        $order = $request->get('order'); 
        $dir = $request->get('dir'); 
        $page_appends = null;
        $searchText = $request->get('searchText');

        $users = Users::whereIn('valid', [0, 1]);

        //добавляем условия поиска, если они заданы
        if (!empty($searchText)) {
            $users = $users
                        ->where('login', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('name', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('dopname', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('phone', 'LIKE', '%' . $searchText . '%');
        }

        if ($order && $dir) {
            $users = $users->orderBy($order, $dir);
            $page_appends = [
                'order' => $order,
                'dir' => $dir,
            ];
        } 

        $users = $users->paginate(config('app.users_on_page_admin'))->appends(['searchText' => $searchText]);
        Session::put('page', $users->currentPage());

        $data['users'] = $users;
        $data['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data['page_appends'] = $page_appends;
        $data['searchText'] = $searchText;

        return view('layouts.admin.users', ['data' => $data, 'message'=>'']);
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
                $root = $_SERVER['DOCUMENT_ROOT'] . '/uploads/portfolio/' . $user->id;
                File::deleteDirectory($root);
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
        $oldfile = $user->portfolio;
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'name' => 'required|max:250',
            'dopname' => 'max:80',
            'phone' => 'required|max:60',
            'pay_till' => 'date|nullable',
            'portfolio' => 'file|max:500|mimes:pdf,doc,docx,rtf',
        ]); 
        $form = $request->all();
        //dd($oldfile, $form);

        if(!empty($form['portfolio'])) {
            $file = $form['portfolio'];
            $new_file = str_random(8) . '.' . $file->getClientOriginalExtension();
            $root = $_SERVER['DOCUMENT_ROOT'] . '/uploads/portfolio/' . $user->id;
            if(!file_exists($root)) {
                if (!mkdir($root, 0777, true)) {
                        dump('Не могу создать папку для файлов');
                    }
            }
            $file->move($root, $new_file);
            if (!empty($oldfile)) {
                File::delete($root.'/'.$oldfile);
            }

            $form['portfolio'] = $new_file;
        } else {
            $form['portfolio'] = $oldfile;
        }
        //dd($form, $oldfile, $new_file);

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
