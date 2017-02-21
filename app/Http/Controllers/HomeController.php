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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Exception;
use Response;
use App\Users;
use App\Objects;
use App\Requests;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //показываем все незаблокированные объекты и заявки
        $objects = Objects::whereIn('disabled', [0]);
        $requests = Requests::whereIn('disabled', [0]);

        $page_o = $request->get('page_o');
        $page_r = $request->get('page_r');
        $page_o = (isset($page_o)) ? $page_o : 1;
        $page_r = (isset($page_r)) ? $page_r : 1;

        $objectName = $request->get('objectName');
        $beginDate = $request->get('beginDate');

        //добавляем условия поиска, если они заданы
        if (!empty($objectName)) {
            $objects = $objects
                        ->where('object_name', 'LIKE', '%' . $objectName . '%');
            $requests = $requests
                        ->where('request_name', 'LIKE', '%' . $objectName . '%');
        }

        if (!empty($beginDate)) {
            $objects = $objects
                        ->where('free_since', '>', $beginDate);
            $requests = $requests
                        ->where('start_date', '>', $beginDate);
        }

        $objects = $objects->paginate(config('app.objects_on_page'), ['*'], 'page_o')
            ->appends(['page_o' => $page_o, 'page_r' => $page_r, 'objectName' => $objectName,
                'beginDate' => $beginDate]);

        $requests = $requests->paginate(config('app.objects_on_page'), ['*'], 'page_r')
            ->appends(['page_o' => $page_o, 'page_r' => $page_r, 'objectName' => $objectName,
                'beginDate' => $beginDate]);

        $data['objects'] = $objects;
        $data['requests'] = $requests;

        return view('home', ['data' => $data, 'message'=>'']);
    }
}
