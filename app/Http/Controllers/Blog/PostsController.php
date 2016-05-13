<?php

namespace App\Http\Controllers\blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\BlogPosts;
use App\Http\Requests\Blog\BlogPostsRequest;
use Session;
use Gate;
use User;

class PostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = BlogPosts::orderBy('updated_at', 'DESC')->paginate(5);

        $data = array(
            'posts' => $posts
        );

        return view('blog.posts.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $post = new BlogPosts;
        
        if($request->feature_image != null){
            $file = $request->feature_image;
            $extension = $file->getClientOriginalExtension();
            Storage::disk('local')->put($file->getFilename() . '.' . $extension, File::get($file));
            $filename = $file->getFilename() . '.' . $extension;
            $link = url('../storage/app') . '/' . $filename;
            $post->feature_image = $link;
        }        

        $post->title = $request->title;
        $post->description = $request->description;
        $post->content = $request->content;
        $post->is_draft = $request->is_draft;
        $post->save();
        
        Session::flash('flash-message', 'Success!');

        return redirect()->route('blog.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = BlogPosts::findorfail($id);

        $data = array(
            'post' => $post,
        );

        return view('blog.posts.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPosts::findorfail($id);

        return response::json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPostsRequest $request, $id)
    {
        $post = BlogPosts::findorfail($id);

//        if ($post->feature_image != null) {
//            Storage::delete($post->feature_image);
//        }
//        if(Input::hasFile('feature_image')){
//            $file = Input::file('feature_image');
//            $extension = $file->getClientOriginalExtension();
//            Storage::disk('local')->put($file->getFilename() . '.' . $extension, File::get($file));
//            $filename = $file->getFilename() . '.' . $extension;
//            $link = url('../storage/app') . '/' . $filename;
//            $post->feature_image = $link;
//        }        
        

        $post->title = $request->title;
        $post->description = $request->description;
        $post->content = $request->content;
//        $post->feature_image = $link;
        $post->save();

        return response::json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPosts::findorfail($id);

        Storage::delete($post->feature_image);

        $post->delete();

        return response::json($post);
    }

    public function showList()
    {
        $posts = BlogPosts::orderBy('updated_at', 'DESC')->paginate(10);

        $data = array(
            'posts' => $posts
        );

        return view('blog.posts.list')->with($data);
    }
}
