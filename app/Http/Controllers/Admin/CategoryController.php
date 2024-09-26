<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('created_at','desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request)
    {
        try{
            Category::create([
                'name' => $request->name
            ]);
            return back()->with('success','Category has been saved');
        }catch(Exception $e){
            return back()->with('error','Failed to save category');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        try{
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->save();
            return back()->with('success','Category has been updated');
        }catch(Exception $e){
            return back()->with('error','Failed to update category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $category = Category::findOrFail($id);
            $category->delete();
            return back()->with('success','Category has been deleted');
        }catch(Exception $e){
            return back()->with('error','Failed to delete category');
        }
    }

    public function updateStatus(string $id){
        try{
            $row = Category::findOrFail($id);
            $row->status = ($row->status == 1) ? 0 : 1;
            $row->save();
            return back()->with('success', 'Status has been updated successfully.');
        }catch(Exception $e){
            return back()->with('error', 'Failed to update status.');
        }
    }


}
