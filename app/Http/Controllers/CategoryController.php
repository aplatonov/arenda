<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::user()->role_id == 1) {
            return view('layouts.admin.categories', compact('categories', 'allCategories'));
        } else {
            return redirect()->back()->with('message', 'Недостаточно прав для управления категориями');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($parent_id)
    {
        if (Auth::user()->role_id == 1) {
            $parent_cat = Categories::find($parent_id);
            if ($parent_cat) {
                $parent_name = $parent_cat->name_cat;
            } else {
                $parent_name = null;
            }
            return view('layouts.admin.categoryCreate', ['parent_id' => $parent_id,
                                                     'parent_name' => $parent_name]);
        } else {
            return redirect()->back()->with('message', 'Недостаточно прав для создания категории');
        }
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
            'name_cat' => 'required|max:50',
        ]);

        $form = $request->all();

        $category = Categories::create($form);

        return redirect('admin/categories')->with('message', 'Категория создана успешно.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->role_id == 1) {
            $category = Categories::findOrFail($id);
            return view('layouts.admin.categoryEdit', ['category'=>$category]);
        } else  {
            return redirect()->back()->with('message', 'Недостаточно прав для редактирования категории');
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
        $category = Categories::find($id);
        $this->validate($request, [
            'name_cat' => 'required|max:50',
        ]);

        $form = $request->all();

        $category->update($form);

        return redirect('admin/categories')->with('message', 'Категория '.$category->name_cat.' обновлена успешно.');
    }

    public function delete($id)
    {
        if (Auth::user()->role_id == 1) {
            $category = Categories::findOrFail($id);
            $category_name = $category->name_cat;
            $cnt = $category->childs->count() + $category->objects->count() + $category->requests->count();
            if ($cnt == 0) {
                try {
                    $category->delete();
                    return redirect('admin/categories')->with('message', 'Категория '.$category_name.' удалена.');
                } catch (Exception $e) {
                    return redirect()->back()->with('message', 'Невозможно удалить категорию '.$category_name);
                }
            } else {
                return redirect()->back()->with('message', 'Невозможно удалить категорию '. $category_name . ' т.к. она содержит подкатегории, объекты или заявки');
            }
        } else {
            return redirect()->back()->with('message', 'Недостаточно прав для удаления категории');
        }
    }


}