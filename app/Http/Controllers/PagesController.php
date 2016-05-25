<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Chapters;
use App\Comics;
use App\Pages;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;
use Gate;

class PagesController extends Controller
{

    public function __construct()
    {
        // Middleware for all functions
        $this->middleware('admin');

        // Use middleware only on some functions
        $this->middleware('admin', ['only' => 'create', 'edit']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Comics $comic, Chapters $chapter)
    {
        $data = [
            'comic' => $comic,
            'chapter' => $chapter,
        ];

        return view('pages/create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Comics $comic, Chapters $chapter, Request $request)
    {
        $user = Auth::guard('admin')->user();
        $auth = Auth::guard('admin')->check();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect()->route('admin.login');
        }

        $page = new Pages;

        //$file = $_FILES['file-0'];
        $file = Request::file('file-0');

        $extension = $file->getClientOriginalExtension();
        if ($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg') {
            Session::flash('flash_error', 'Just allow file jpg, jpeg, png');
            return Response::json($page);
        }

        $filename = $file->getFilename() . '.' . $extension;

        Storage::disk('public')->put(
            $comic->slug . '/' .
            $chapter->name . '/' .
            $filename, File::get($file)
        );
        $link = $comic->slug . '/' . $chapter->name . '/' . $filename;

        $page->chapter_id = $chapter->id;
        $page->link = $link;

        $page->save();

        return Response::json($page);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comics $comic, Chapters $chapter, Pages $page)
    {
        return Response::json($page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Comics $comic, Chapters $chapter, Request $request, Pages $page)
    {
//        Storage::delete($page->link);
//
//        //$file = $request->file;
//        $file = Request::file('file-0');
//        
//        $extension = $file->getClientOriginalExtension();
//        if ($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg') {
//            Session::flash('flash_error', 'Just allow file jpg, jpeg, png');
//            return Response::json($page);
//        }
//
//        $filename = $file->getFilename() . '.' . $extension;
//
//        Storage::disk('public')->put(
//            $comic->slug . '/' .
//            $chapter->name . '/' .
//            $filename, File::get($file)
//        );
//        $link = url('../storage/app/public') . '/' .
//                    $comic->slug . '/' .
//                    $chapter->name . '/' . $filename;
//        
//        $page->chapter_id = $chapter->id;
//        $page->link = $link;
//        $page->update();
//        
//        return Response::json($page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAjax(Comics $comic, Chapters $chapter, Request $request, Pages $page)
    {
        $user = Auth::guard('admin')->user();
        $auth = Auth::guard('admin')->check();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect()->route('admin.login');
        }
        
        $pages = Pages::findorfail(Request::get('page_id'));
        
        Storage::disk('public')->delete($pages->link);

        //$file = $request->file;
        $file = Request::file('file-0');
        
        
        
        $extension = $file->getClientOriginalExtension();
        if ($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg') {
            Session::flash('flash_error', 'Just allow file jpg, jpeg, png');
            return Response::json($pages);
        }
        $comic_slug = Request::get('comic_slug');
        $chapter_name = Request::get('chapter_name');
        
        $filename = $file->getFilename() . '.' . $extension;

        Storage::disk('public')->put($comic_slug . '/' . $chapter_name . '/' . $filename, File::get($file));
        $link = $comic_slug . '/' . $chapter_name . '/' . $filename;
        
        
        
        $pages->link = $link;
        $pages->update();

        return Response::json($pages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comics $comic, Chapters $chapter, Pages $page)
    {
        $user = Auth::guard('admin')->user();
        $auth = Auth::guard('admin')->check();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect()->route('admin.login');
        }
        Storage::disk('public')->delete($page->link);
        
        $page->delete();
        
        return Response::json($page);
    }
}
