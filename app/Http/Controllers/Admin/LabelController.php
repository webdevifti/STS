<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabelCreateRequest;
use App\Http\Requests\LabelUpdateRequest;
use App\Models\Label;
use Exception;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = Label::orderBy('created_at','desc')->get();
        return view('admin.labels.index', compact('labels'));
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(LabelCreateRequest $request)
    {
        try{
            Label::create([
                'name' => $request->name
            ]);
            return back()->with('success','Label has been saved');
        }catch(Exception $e){
            return back()->with('error','Failed to save label');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(LabelUpdateRequest $request, string $id)
    {
        try{
            $label = Label::findOrFail($id);
            $label->name = $request->name;
            $label->save();
            return back()->with('success','Label has been updated');
        }catch(Exception $e){
            return back()->with('error','Failed to update label');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $label = Label::findOrFail($id);
            $label->delete();
            return back()->with('success','Label has been deleted');
        }catch(Exception $e){
            return back()->with('error','Failed to delete label');
        }
    }

    public function updateStatus(string $id){
        try{
            $row = Label::findOrFail($id);
            $row->status = ($row->status == 1) ? 0 : 1;
            $row->save();
            return back()->with('success', 'Status has been updated successfully.');
        }catch(Exception $e){
            return back()->with('error', 'Failed to update status.');
        }
    }

}
