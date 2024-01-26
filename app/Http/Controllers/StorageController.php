<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function index()
    {
        $storage = \App\Helpers\Storage::dirToArray(storage_path('/app/public'));
       return Response::json($storage,200);
    }

    public function delete(Request $request)
    {
        return Response::json(
            Storage::delete('/public/'.$request->input('file')), 200
        );
    }
    public function store(Request $request)
    {
        foreach ($request->file('files') as $file)
        {
            Storage::putFileAs('/public/'.$request->input('dir'), $file, $file->getClientOriginalName());
        }
    }
}
