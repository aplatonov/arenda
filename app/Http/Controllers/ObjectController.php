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
use App\Objects;

class ObjectController extends Controller
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
        return view('objectCreate');
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
            'object_name' => 'required|unique:objects|max:200',
            'description' => 'required',
            'category_id' => 'required',
            'year' => 'numeric|digits:4',
            'min_period' => 'numeric|nullable',
            'price' => 'numeric|required',
            'free_since' => 'date|nullable',
            'disabled' => 'boolean',
        ]); 
        
        $form = $request->all();
        if (isset($form['disabled'])) {
            $form['disabled'] = '1';         
        }
        else {
            $form['disabled'] = '0';
        }
        
        $object = Objects::create($form);
        
        //return redirect('objects/'.$object->id);
        return redirect('objects');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $object = Objects::findOrFail($id);

        return view('objectShow', ['object' => $object]);
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showObjects(Request $request)
    {
        $order = $request->get('order'); 
        $dir = $request->get('dir'); 
        $page_appends = null;

        if (Auth::user()->role_id == 1) 
        {
            //админу показываем все лоты
            $objects = Objects::whereIn('disabled', [0, 1]);
        }
        else
        {
            //пользователю показываем незаблокированные лоты и его собственнные заблокированные
            $objects = Objects::where('disabled', 0)
                ->orWhere(function ($query) {
                    $query->where('owner_id', Auth::user()->id)
                        ->where('disabled', 1);
                });        
        }

        if ($order && $dir) {
            $objects = $objects->orderBy($order, $dir);
            $page_appends = [
                'order' => $order,
                'dir' => $dir,
            ];
        } 

        $objects = $objects->paginate(config('app.objects_on_page'));

        $data['objects'] = $objects;
        $data['dir'] = $dir == 'asc' ? 'desc' : 'asc';
        $data['page_appends'] = $page_appends;

        return view('layouts/objects', ['data' => $data, 'message'=>'']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $object = Objects::find($id);
        if (Auth::user()->role_id == 1 || Auth::user()->id == $object->owner_id) {
            return view('objectEdit', ['object'=>$object]);
        } else  {
            return redirect()->back()->with('message', 'Недостаточно прав для редактирования объекта');
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
        $object = Objects::find($id);
        $this->validate($request, [
            'object_name' => 'required|max:200',
            'description' => 'required',
            'category_id' => 'required',
            'year' => 'numeric|digits:4',
            'min_period' => 'numeric|nullable',
            'price' => 'numeric|required',
            'free_since' => 'date|nullable',
            'disabled' => 'boolean',
        ]); 

        $form = $request->all();
        if (isset($form['disabled'])) {
            $form['disabled'] = '1';        
        }
        else {
            $form['disabled'] = '0';
        }

        $object->update($form);
        
        return redirect('objects/'.$object->id);
    }

    /**
     * Destroy a object instance after by valid user role.
     *
     * @param  integer  $id
     * @return string
     */
    public function destroyObject($id)
    {
        $object = Objects::findOrFail($id);
        if (Auth::user()->role_id == 1 || Auth::user()->id == $object->owner_id) {     
            $objectname = $object->object_name;
            try {
                $object->delete();
                return redirect()->back()->with('message', 'Объект '.$objectname.' удален');
            } catch (Exception $e) {
                return redirect()->back()->with('message', 'Невозможно удалить объект '.$objectname);
            }
        } else {
            return redirect()->back()->with('message', 'Недостаточно прав для удаления объекта');
        }
    }

    
    public function blockObject(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $object = Objects::findOrFail($request->input('object_id'));
            $object->disabled = $request->input('action');
            $object->save();
            $data = array( 'text' => 'success' );
        } else {
            $data = array( 'text' => 'fail' . $request->input('action') );
        }
        return Response::json($data);
    }  

    
    public function showContactInfo(Request $request)
    {
        if (Auth::user()->confirmed == 1 && Auth::user()->valid == 1) {
            $object = Objects::findOrFail($request->input('object_id'));
            $object_info = '<small>' . $object->owner->name . '<br>' . $object->owner->dopname . '<br>' . $object->owner->phone . '<small>';
            $data = array( 'text' => 'success', 'object_info' => $object_info);
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
