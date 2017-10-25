<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;


class UploadController extends Controller
{
    public function store(Request $request)
    {
        Log::info($request->all());

        $file = $request->file('file');

        if (! is_array($file))
            Log::info('Storing file ' . $file->getClientOriginalName());

        $path = $file->store('files');
        Log::info('stored ' . $path);

        return $path;
    }

    public function drop(Request $request)
    {
        $name = $request->input('response');

        Log::info('Removing file');
        Log::info($name);

        if (Storage::exists($name))
            Log::info('exists');
        else
            Log::info('not found');

        if (Storage::exists($name))
            Storage::delete($name);

        return $name;
    }
}
