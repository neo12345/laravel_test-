<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\blog\TagCreateRequest;
use App\Tag;
use Session;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('updated_at', 'DESC')->paginate(10);
        
        $data = array(
            'tags' => $tags
        );
        return view('blog.tag.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagCreateRequest $request)
    {
        $input = $request->all();
        
        Tag::create($input);
        
        Session::flash('flash_message', 'Success');
        
        return redirect()->route('blog.tag.index');
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
    public function edit($id)
    {
        $tag = Tag::findorfail($id);
        
        $data = array(
            'tag' => $tag
        );
        return view('blog.tag.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagCreateRequest $request, $id)
    {
        $tag = Tag::findorfail($id);
        
        $input = $request->all();
        
        $tag->fill($input)->save();
        
        Session::flash('flash_message', 'Success');
        
        return redirect()->route('blog.tag.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findorfail($id);
        $tag->delete();
        
        Session::flash('flash_message', 'Success');
        
        return redirect()->route('blog.tag.index');
    }
}
