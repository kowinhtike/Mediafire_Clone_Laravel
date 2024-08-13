<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $folder = Folder::find($id);
        if (isset($folder->files)) {
            $files = $folder->files;
            return response()->json($files);
        } else {
            return response()->json([
                'message' => "empty file"
            ]);;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id)
    {
        $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
        //Find the channel by name
        $folder = Folder::find($id);

        $fileNumbers = 1;
        // // Determine the next post number for this channel
        if (isset($folder->files)) {
            $fileNumbers = $folder->files()->max('number') + 1;
        }


        $imagefile = $request->file('image');
        $getImageName = $imagefile->hashName();

        $file = new File();
        $file->file = $getImageName;
        $file->folder_id = $id;
        $file->number = $fileNumbers;
        Storage::putFileAs('public/images', $imagefile, $getImageName);
        $file->save();
        return response()->json($file);
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
    public function show(Request $request, $id, $number)
    {

        //
        $folder = Folder::find($id);
        if (isset($folder->files)) {
            $file = File::where('folder_id', $id)->where('number', $number)->first();
            if (isset($file->id)) {
                return response()->json($file);
            } else {
                return response()->json([
                    'message' => "empty file"
                ]);;
            }
        } else {
            return response()->json([
                'message' => "empty file"
            ]);;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id, $number)
    // {
    //     return "nice";
    // }

    public function update(Request $request, $id, $number)
    {
        // Validate the new image file
        $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

        // Find the folder and file by ID and number
        $folder = Folder::find($id);
        if (isset($folder->files)) {
            $file = File::where('folder_id', $id)->where('number', $number)->first();

            if (isset($file->id)) {
                // Delete the old image file from storage
                Storage::delete("public/images/" . $file->file);

                // Store the new image file
                $imagefile = $request->file('image');
                $getImageName = $imagefile->hashName();
                Storage::putFileAs('public/images', $imagefile, $getImageName);

                // Update the file information in the database
                $file->file = $getImageName;
                $file->save();

                return response()->json($file);
            } else {
                return response()->json([
                    'message' => "File cannot get"
                ], 404);
            }
        } else {
            return response()->json([
                'message' => "folder not found"
            ], 404);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $number)
    {
        //
        $folder = Folder::find($id);
        if (isset($folder->files)) {
            $file = File::where('folder_id', $id)->where('number', $number)->first();
            if (isset($file->id)) {
                Storage::delete("public/images/" . $file->file);
                $file->delete();
                return response()->json($file);
            } else {
                return response()->json([
                    'message' => "empty file"
                ]);
            }
        } else {
            return response()->json([
                'message' => "empty file"
            ]);
        }
    }
}
