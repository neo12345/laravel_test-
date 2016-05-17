<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CheckPostsRequest;
use App\Posts;
use User;
use Gate;
use Session;
use Auth;
use Cache;

class PostsController extends Controller
{

    public function index()
    {
        $posts = Cache::remember('posts', 10, function() {
            return Posts::orderBy('updated_at', 'desc')->paginate(10);
        });

        $data = array(
            'posts' => $posts
        );

        return view('posts.index')->with($data);
    }

    public function show($id)
    {
        $post = Posts::findorfail($id);

        $data = array(
            'post' => $post
        );

        return view('posts.show')->with($data);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(CheckPostsRequest $request)
    {
        $input = $request->all();

        $job = (new \App\Jobs\QueueWorks($input, 'posts'))->delay(60);
        $this->dispatch($job);

        Session::flash('flash_message', 'Post successfully added');
        Cache::forget('posts');

        return redirect()->route('posts.index');
    }

    public function edit($id)
    {
        $post = Posts::findorfail($id);
        $user = Auth::user();
        if (Gate::forUser($user)->allows('update-post')) {
            Session::flash('flash_message', 'You have permission to update post');
        }
        
        $data = array(
            'post' => $post
        );

        return view('posts.edit')->with($data);
    }

    public function update(CheckPostsRequest $request, $id)
    {
        $post = Posts::findorfail($id);

        $input = $request->all();

        $post->fill($input)->save();

        Session::flash('flash_message', 'Post successfully edited');
        Cache::forget('posts');

        return redirect()->route('posts.show', $post->id);
    }

    public function destroy($id)
    {
        $post = Posts::findorfail($id);

        $post->delete();

        Session::flash('flash_message', 'Post successfully deleted');
        Cache::forget('posts');

        return redirect()->route('posts.index');
    }
}
