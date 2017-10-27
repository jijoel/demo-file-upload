<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Log;


class UploadController extends Controller
{
    public function store(Request $request)
    {
        Log::info($request->all());

        $files = $request->file('file');

        if (! is_array($files))
            $files = [$files];

        $stored = [];
        foreach($files as $file) {
            Log::info('Storing file ' . $file->getClientOriginalName());
            $path = $file->store('files');
            Log::info('stored ' . $path);
            $stored[] = $path;
        }

        return $stored;
    }

    public function drop(Request $request)
    {
        $files = json_decode($request->input('response'));

        $dropped = [];
        foreach($files as $file) {
            Log::info('Removing file');
            Log::info($file);
            Log::info(Storage::exists($file) ? 'exists' : 'not found');

            if (Storage::exists($file))
                Storage::delete($file);

            $dropped[] = $file;
        }

        return $dropped;
    }
}
