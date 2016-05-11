<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use Session;
use App\Http\Requests;

class NewsController extends Controller
{

    protected $rules = array(
        'title' => ['required', 'min: 5'],
        'description' => ['required'],
        'content'=> ['required']
    );


    public function index()
    {
        $news = News::all();

        $data = array(
            'news' => $news
        );

        return view('news.index')->with($data);
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $input = $request->all();

        $job = (new \App\Jobs\QueueWorks($input, 'news'))->delay(60);
        $this->dispatch($job);
        Session::flash('flash_message', 'News successfully added');

        return redirect()->route('news.index');
    }

    public function show($id)
    {
        $news = News::findorfail($id);

        $data = array(
            'news' => $news
        );

        return view('news.show')->with($data);
    }

    public function edit($id)
    {
        $news = News::findorfail($id);

        $data = array(
            'news' => $news
        );

        return view('news.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $input = $request->all();

        $news = News::findorfail($id);

        $news->fill($input)->save();

        Session::flash('flash_message', 'News successfully edited');

        return redirect()->route('news.show', $news->id);
    }

    public function destroy($id)
    {
        $news = News::findorfail($id);

        $news->delete();

        Session::flash('flash_message', 'News successfully deleted!');

        return redirect()->route('news.index');
    }
}
