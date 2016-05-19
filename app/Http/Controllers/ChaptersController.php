<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Chapters;
use App\Comics;
use Session;

class ChaptersController extends Controller
{

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
        $data = array(
            'chapter' => $chapter,
            'comic' => $comic,
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
        $chapter->delete();
        
        Session::flash('flash_message', 'Success!');
        
        return redirect()->route('comics.show', $comic->slug);
    }
}
