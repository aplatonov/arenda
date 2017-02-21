<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Categories;

class CategoryController extends Controller

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
     * Show the category tree view.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageCategory()

    {
        return view('layouts.admin.categories', compact('categories','allCategories'));
    }


    /**
     * Adds category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return view
     */
    public function addCategory(Request $request, $id)

    {
        $this->validate($request, [
            'name_cat' => 'required',
        ]);

        $input = $request->all();
        $input['parent_id'] = $id;

        Categories::create($input);

        return back()->with('success', 'Категория создана успешно.');

    }

    public function destroyCategory($id)
    {
        //
    }


}