<?php namespace App\Http\Controllers;
 
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use Session;
 
use Illuminate\Http\Request;
 
class TasksController extends Controller {
 
	
	public function index()
	{
		$tasks = Task::all();

        return view('tasks.index')->withTasks($tasks);
	}
 
	/**
	 * Show the form for creating a new resource.
	 *
	 * @param  \App\Project $project
	 * @return Response
	 */
	public function create()
    {
        return view('tasks.create');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'task' => 'required',
            'description' => 'required'
        ]);
        
        $input = $request->all();

        Task::create($input);
        
        Session::flash('flash_message', 'Task successfully added!');

        return redirect()->back();
    }
    
    public function show($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.show')->withTask($task);
    }
    
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.edit')->withTask($task);
    }
    
    public function update($id, Request $request)
    {
        $task = Task::findOrFail($id);

        $this->validate($request, [
            'task' => 'required',
            'description' => 'required'
        ]);

        $input = $request->all();

        $task->fill($input)->save();

        Session::flash('flash_message', 'Task successfully added!');

        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        Session::flash('flash_message', 'Task successfully deleted!');

        return redirect()->route('tasks.index');
    }
 
}