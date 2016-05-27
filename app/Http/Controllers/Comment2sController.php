<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment2s;
use Gate;
use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class Comment2sController extends Controller
{
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
            'chapter_id' => 'required|numeric',
        ]);

        $comment = new Comment2s;

        $comment->comment = $request->comment;
        $comment->chapter_id = $request->chapter_id;
        $comment->reply_to = $request->reply_to;

        if (!Auth::check() && !Auth::guard('admin')->check()) {
            $comment->user_id = 0;
            $comment->username = 'Anonymous';
        } else {
            $comment->user_id = $request->user_id;
            $comment->username = $request->username;
        }

        $comment->save();

        return Response::json($comment);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment2s::findorfail($id);
        $comment->delete();
        
        return redirect()->back();
    }
}
