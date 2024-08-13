<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        return $request->user()->folders;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $folder = new Folder();
        $folder->name = $request->name;
        $folder->user_id = $request->user()->id;
        $folder->save();
        return response()->json($folder);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $folder = Folder::find($id);
        if(isset($folder->id)){
            return response()->json($folder);
        }else{
            return response()->json($folder);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $folder = Folder::find($id);
        $folder->name = $request->name;
        $folder->save();
        return response()->json($folder);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $folder = Folder::find($id);
        $folder->delete();
        return response()->json($folder);
    }
}
