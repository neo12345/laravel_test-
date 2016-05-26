<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Chapters;
use App\Comics;
use Session;
use Gate;
use Auth;

class ChaptersController extends Controller
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
    public function index(Comics $comic)
    {
        return view('comics.index', $comic->slug);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Comics $comic)
    {
        $data = array(
            'comic' => $comic,
        );

        return view('chapters.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Comics $comic)
    {
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect('admin/login');
        }

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $chapter = new Chapters;
        $chapter->fill($request->all());
        //$chapter->comic_id = $comic->id;
        $chapter->save();

        $comic->chapters()->save($chapter);

        Session::flash('flash_message', 'Success!');

        return redirect()->route('comics.show', $comic->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comics $comic, Chapters $chapter)
    {
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        
        $next = Chapters::where('id', '>', $chapter->id)
            ->where('comic_id', '=', $comic->id)
            ->first();
        $prev = Chapters::where('id', '<', $chapter->id)
            ->where('comic_id', '=', $comic->id)
            ->first();

        $data = array(
            'user' => $user,
            'auth' => $auth,
            'chapter' => $chapter,
            'comic' => $comic,
            'next' => $next,
            'prev' => $prev,
        );

        return view('chapters.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comics $comic, Chapters $chapter)
    {
        $data = array(
            'chapter' => $chapter,
            'comic' => $comic,
        );

        return view('chapters.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comics $comic, Chapters $chapter)
    {
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect('admin/login');
        }

        $chapter->fill($request->all());

        $chapter->save();

        Session::flash('flash_message', 'Success!');

        return redirect()->route('comics.chapters.show', [$comic->slug, $chapter->name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comics $comic, Chapters $chapter)
    {
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect('admin/login');
        }

        $chapter->delete();

        Session::flash('flash_message', 'Success!');

        return redirect()->route('comics.show', $comic->slug);
    }
}
