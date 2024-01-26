<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('products');
        if($request->input('category_name') && $request->input('category_name') != 'null')
        {
            $categories = $categories->where('name', 'like', '%'.$request->input('category_name').'%');
        }
        if($request->input('sortByAsc') && $request->input('sortByAsc') != 'null')
        {
            $categories = $categories->orderBy($request->input('sortByAsc'), 'asc');
        }
        if($request->input('sortByDesc')  && $request->input('sortByDesc') != 'null')
        {
            $categories = $categories->orderBy($request->input('sortByDesc'), 'desc');
        }
        return Response::json($categories->get(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = Category::create(['name' => $request->input('name')]);
        return Response::json($category, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Category::destroy($id);
    }
}
