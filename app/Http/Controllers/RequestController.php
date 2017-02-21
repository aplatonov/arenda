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
use App\Requests;

class RequestController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('requestCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'request_name' => 'required|max:191',
            'comment' => 'required',
            'category_id' => 'required',
            'start_date' => 'date|required',
            'finish_date' => 'date|required',
            'disabled' => 'boolean',
        ]); 
        
        $form = $request->all();
        if (isset($form['disabled'])) {
            $form['disabled'] = '1';         
        }
        else {
            $form['disabled'] = '0';
        }
        
        $req = Requests::create($form);
        
        return redirect('requests');
    }

    public function showRequests(Request $request)
    {
        $order = $request->get('order'); 
        $dir = $request->get('dir'); 
        $page_appends = null;

        if (Auth::user()->role_id == 1) 
        {
            //админу показываем все заявки
            $requests = Requests::whereIn('disabled', [0, 1]);
        }
        else
        {
            //пользователю показываем незаблокированные заявки и его собственнные заблокированные
            $requests = Requests::where('disabled', 0)
                ->orWhere(function ($query) {
                    $query->where('owner_id', Auth::user()->id)
                        ->where('disabled', 1);
                });        
        }

        if ($order && $dir) {
            $requests = $requests->orderBy($order, $dir);
            $page_appends = [
                'order' => $order,
                'dir' => $dir,
            ];
        } 

        $requests = $requests->paginate(config('app.objects_on_page'));

        $data['requests'] = $requests;
        $data['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data['page_appends'] = $page_appends;

        return view('layouts/requests', ['data' => $data, 'message'=>'']);
    }

    public function indexUserRequests(Request $request)
    {
        $order = $request->get('order');
        $dir = $request->get('dir');
        $page_appends = null;

        //хозяину показываем все заявки
        $requests = Requests::whereIn('disabled', [0, 1])->where('owner_id', Auth::user()->id);

        if ($order && $dir) {
            $requests = $requests->orderBy($order, $dir);
            $page_appends = [
                'order' => $order,
                'dir' => $dir,
            ];
        }

        $requests = $requests->paginate(config('app.objects_on_page'));

        $data['requests'] = $requests;
        $data['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data['page_appends'] = $page_appends;

        if (Auth::check()) {
            $username = Auth::user()->name . ' (' . Auth::user()->login . ')';
        } else {
            $username = '';
        }

        return view('layouts/requests', ['data' => $data, 'title'=>' пользователя '.$username]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $req = Requests::findOrFail($id);

        return view('requestShow', ['req' => $req]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $req = Requests::find($id);
        if (Auth::user()->role_id == 1 || Auth::user()->id == $req->owner_id) {
            return view('requestEdit', ['req'=>$req]);
        } else  {
            return redirect()->back()->with('message', 'Недостаточно прав для редактирования запроса');
        }
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
        $req = Requests::find($id);
        $this->validate($request, [
            'request_name' => 'required|max:200',
            'comment' => 'required',
            'category_id' => 'required',
            'start_date' => 'date',
            'finish_date' => 'date',
            'disabled' => 'boolean',
        ]); 

        $form = $request->all();
        if (isset($form['disabled'])) {
            $form['disabled'] = '1';        
        }
        else {
            $form['disabled'] = '0';
        }

        $req->update($form);
        
        return redirect('requests/'.$req->id);
    }

    /**
     * Destroy a object instance after by valid user role.
     *
     * @param  integer  $id
     * @return string
     */
    public function destroyRequest($id)
    {
        $req = Requests::findOrFail($id);
        if (Auth::user()->role_id == 1 || Auth::user()->id == $req->owner_id) {     
            $request_name = $req->request_name;
            try {
                $req->delete();
                return redirect()->back()->with('message', 'Заявка '.$request_name.' удалена');
            } catch (Exception $e) {
                return redirect()->back()->with('message', 'Невозможно удалить заявку '.$request_name);
            }
        } else {
            return redirect()->back()->with('message', 'Недостаточно прав для удаления заявки');
        }
    }

    public function showRequestContact(Request $request)
    {
        if (Auth::user()->confirmed == 1 && Auth::user()->valid == 1) {
            $req = Requests::findOrFail($request->input('request_id'));
            $request_info = '<small>' . $req->owner->name . '<br>' . $req->owner->dopname . '<br>' . $req->owner->phone . '<small>';
            $data = array( 'text' => 'success', 'request_info' => $request_info);
        } else {
            $data = array( 'text' => 'fail' . $request->input('action') );
        }
        return Response::json($data);
    }   

    public function blockRequest(Request $request)
    {
        $req = Requests::findOrFail($request->input('request_id'));
        if (Auth::user()->role_id == 1 || Auth::user()->id == $req->owner_id) {
            $req->disabled = $request->input('action');
            $req->save();
            $data = array( 'text' => 'success' );
        } else {
            $data = array( 'text' => 'fail' . $request->input('action') );
        }
        return Response::json($data);
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
