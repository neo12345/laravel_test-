<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
//use App\Http\Requests;
use App\Comics;
use App\Categories;
use Cache;
use Session;
use Gate;
use Illuminate\Support\Facades\Auth;

class ComicsController extends Controller
{

    public function __construct()
    {
        // Middleware for all functions
        $this->middleware('admin');

        // Use middleware only on some functions
        $this->middleware('admin', ['only' => 'create', 'edit', 'editCategory']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        $comics = Comics::where('publish', '=', '1')->orderBy('updated_at', 'DESC')->paginate(5);

        $data = array(
            'user' => $user,
            'auth' => $auth,
            'comics' => $comics,
        );

        return view('comics.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect('admin/login');
        }

        $this->validate($request, [
            'name' => 'required|max:255|unique:comics',
            'slug' => 'required|max:255|unique:comics|alpha_dash',
            'description' => 'required',
        ]);

        $comic = new Comics;

        if ($request->image != null) {
            $file = $request->image;

            $extension = $file->getClientOriginalExtension();
            if ($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg') {
                Session::flash('flash_error', 'Just allow file jpg, jpeg, png');
                return redirect(url('/comics/create'));
            }

            $filename = $request->slug . '.' . $extension;

            Storage::disk('public')->put(
                $request->slug . '/' . $filename, File::get($file)
            );
            $comic->image = url('../storage/app/public') . '/' . $request->slug . '/' . $filename;
        }

        if ($request->publish) {
            $comic->publish = 1;
        } else
            $comic->publish = 0;

        $comic->name = $request->name;
        $comic->slug = $request->slug;
        $comic->description = $request->description;


        $comic->save();

        Session::flash('flash_message', 'Success!');

        Cache::forget('comics');

        return redirect()->route('comics.show', $comic->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comics $comic)
    {
        //$comic = Comics::with('chapters', 'categories')->findorfail($id);//;
        if (Auth::check()) {
            $user = Auth::user();
            $auth = Auth::guard('admin')->check();
        }
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $auth = Auth::guard('admin')->check();
        }
        $comics = Comics::with(['chapters' => function($query) {
                    $query->orderBy('updated_at', 'DESC');
                }], ['comments' => function($query) {
                    $query->orderBy('created_at', 'ACS');
                }], 'categories')
            ->findorfail($comic->id);
        $data = array(
            'user' => $user,
            'auth' => $auth,
            'comic' => $comics,
        );

        return view('comics.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comics $comic)
    {
        //$comic = Comics::with('chapters', 'categories')->findorfail($id);//;

        $data = array(
            'comic' => $comic,
        );

        return view('comics.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comics $comic)
    {
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect('admin/login');
        }

        $this->validate($request, [
            'name' => 'required|max:255',
            'slug' => 'required|max:255|alpha_dash',
            'description' => 'required',
        ]);

        //$comic = Comics::findOrFail($id);

        if ($request->image != null) {
            Storage::delete($comic->image);

            $file = $request->image;

            $extension = $file->getClientOriginalExtension();
            if ($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg') {
                Session::flash('flash_error', 'Just allow file jpg, jpeg, png');
                return redirect(url('/comics/create'));
            }

            $filename = $request->slug . '.' . $extension;

            Storage::disk('public')->put(
                $request->slug . '/' . $filename, File::get($file)
            );
            $link = url('../storage/app/public') . '/' . $request->slug . '/' . $filename;
            $comic->image = $link;
        }

        $comic->name = $request->name;
        $comic->slug = $request->slug;
        $comic->description = $request->description;
        $comic->publish = $request->publish;
        $comic->update();

        Session::flash('flash_message', 'Success!');
        Cache::forget('comics');

        return redirect()->route('comics.show', $comic->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comics $comic)
    {
        //$comic = Comics::findOrFail($id);

        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect('/admin/login');
        }

        Storage::disk('public')->deleteDirectory($comic->slug);

        $comic->delete();

        Session::flash('flash_message', 'Success!');
        Cache::forget('comics');

        return redirect()->route('comics.index');
    }

    /**
     * Show the form for edit category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editCategory(Comics $comic)
    {
        //$comics = Comics::with('categories')->findorfail($comic->id);
        $categories = Categories::all();

        $data = array(
            'comic' => $comic,
            'categories' => $categories,
        );

        return view('comics.editCategory')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCategory(Request $request, Comics $comic)
    {
        //$comic = Comics::findOrFail($id);
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect('admin/login');
        }

        $categories = Categories::all();

        Foreach ($categories as $category) {
            if ($request[$category->slug]) {
                $comic->categories()->attach($category->id);
            } else {
                $comic->categories()->detach($category->id);
            }
        }

        Session::flash('flash_message', 'Success!');

        return redirect()->route('comics.show', $comic->slug);
    }
}
