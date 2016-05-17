<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Files;
use Session;
use Cache;

class FilesController extends Controller
{

    public function index()
    {
        $files = Cache::remember('files', 10, function() {      
            return $files = Files::all();
        });
        $data = array(
            'files' => $files
        );

        return view('files.index')->with($data);
    }

    public function add()
    {
        $file = Request::file('filefield');
        $extension = $file->getClientOriginalExtension();
        if($extension != 'jpg' && $extension != 'png')
        {
            Session::flash('flash_message', 'Just allow file jpg, png');
            return redirect(url('files'));
        }
        Storage::disk('local')->put($file->getFilename() . '.' . $extension, File::get($file));

        $entry = new Files();

        $entry->mime = $file->getClientMimeType();
        $entry->original_filename = $file->getClientOriginalName();
        $entry->filename = $file->getFilename() . '.' . $extension;

        $entry->save();
        
        Cache::forget('files');

        return redirect(url('files'));
    }

    public function get($filename)
    {
        $entry = Files::where('filename', '=', $filename)->firstOrFail();
        $file = Storage::disk('local')->get($entry->filename);

        return (new Response($file, 200))
                ->header('Content-Type', $entry->mime);
    }

    public function delete($filename)
    {
        $entry = Files::where('filename', '=', $filename)->firstorFail();

        //File::delete(Storage::disk('local')->get($entry->filename));
        Storage::disk('local')->delete($entry->filename);
        $entry->delete();
        
        Cache::forget('files');

        return redirect(url('files'));
    }

    public function download($filename)
    {
        $file = Files::where('filename', '=', $filename)->firstorFail();
        return Response()->download(storage_path('app/') . $filename, $file->original_filename);
    }
}
