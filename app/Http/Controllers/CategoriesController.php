<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Categories;
use App\Comics;
use Cache;
use Session;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Cache::remember('categories', 10, function(){
            return Categories::orderBy('name', 'ASC')->Paginate(5);
        });
        
        $data = array(
            'categories' => $categories,
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
        $categories = Categories::with(['comics' => function($query){
            $query->orderBy('updated_at', 'DESC');
        }]
        )->findorfail($category->id);
        
        $data = array(
            'category' => $categories,
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
        $category->delete();
        
        Session::flash('flash_message', 'Success!');
        
        Cache::forget('categories');
        
        return redirect()->route('categories.index');
    }
}
