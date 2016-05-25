<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Categories;
use App\Comics;
use Cache;
use Session;
use Gate;
use Auth;

class CategoriesController extends Controller
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
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();

        $categories = Categories::orderBy('name', 'ASC')->Paginate(5);

        $data = array(
            'categories' => $categories,
            'user' => $user,
            'auth' => $auth,
        );

        return view('categories.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories|alpha_dash',
            'description' => 'required',
        ]);

        $input = $request->all();

        $category = new Categories;

        $category::create($input);

        Session::flash('flash_message', 'Success!');
        Cache::forget('categories');

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $category)
    {
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        $categories = Categories::with(['comics' => function($query) {
                    $query->orderBy('updated_at', 'DESC');
                }]
            )->findorfail($category->id);

        $data = array(
            'category' => $categories,
            'user' => $user,
            'auth' => $auth,
        );

        return view('categories.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $category)
    {
        $data = array(
            'category' => $category,
        );

        return view('categories.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $category)
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

        $input = $request->all();

        $category->fill($input)->update();

        Cache::forget('categories');

        return redirect()->route('categories.show', $category->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $category)
    {
        $auth = Auth::guard('admin')->check();
        $user = Auth::guard('admin')->user();
        if (Gate::forUser($user)->denies('store', $auth)) {
            return redirect('admin/login');
        }

        $category->delete();

        Session::flash('flash_message', 'Success!');

        Cache::forget('categories');

        return redirect()->route('categories.index');
    }
}
