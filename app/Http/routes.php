<?php
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
//use App\Task;
//use Illuminate\Http\Request;

//Route::get('/tasks/{task_id?}',function($task_id){
//    $task = App\Task::find($task_id);
//
//    return Response::json($task);
//});
//
//Route::post('/tasks',function(Request $request){
//    $task = App\Task::create($request->all());
//
//    return Response::json($task);
//});
//
//Route::put('/tasks/{task_id?}',function(Request $request,$task_id){
//    $task = App\Task::find($task_id);
//
//    $task->task = $request->task;
//    $task->description = $request->description;
//
//    $task->save();
//
//    return Response::json($task);
//});
//
//Route::delete('/tasks/{task_id?}',function($task_id){
//    $task = App\Task::destroy($task_id);
//
//    return Response::json($task);
//});
//
//Route::get('/', function () {
//    $tasks = App\Task::all();
//
//    return View::make('tasks.welcome')->with('tasks',$tasks);
//});

Route::resource('tasksajax', 'TasksAjaxController');




Route::get('/', [
    'as' => 'home',
    'uses' => 'PagesController@home'
]);


Route::resource('tasks', 'TasksController', ['only' => ['index', 'show', 'create']]);
Route::resource('news', 'NewsController', ['only' => ['index', 'show', 'create']]);

Route::resource('posts', 'PostsController', ['only' => ['index', 'show', 'create']]);
//Route::resource('posts', 'PostsController');
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
    Route::resource('posts', 'PostsController', ['except' => ['index', 'show', 'create', 'store']]);
    Route::resource('tasks', 'TasksController', ['except' => ['index', 'show', 'create']]);
    Route::resource('news', 'NewsController', ['except' => ['index', 'show', 'create']]);
    Route::get('blog/posts/list', 'Blog\PostsController@showList');
});

Route::group(['middleware' => 'App\Http\Middleware\EditFormCreatePost'], function()
{
    Route::resource('posts', 'PostsController', ['only' => ['store']]);
});

Route::get('files', 'FilesController@index');
Route::get('files/get/{filename}', [
	'as' => 'getentry', 'uses' => 'FilesController@get']);
Route::get('files/download/{filename}', [
	'as' => 'downloadentry', 'uses' => 'FilesController@download']);
Route::post('files/add',[ 
        'as' => 'addentry', 'uses' => 'FilesController@add']);
Route::delete('files/delete/{filename}',[ 
        'as' => 'deleteentry', 'uses' => 'FilesController@delete']);

Route::auth();

Route::get('/home', 'HomeController@index');

Route::resource('emails', 'EmailsController');
Route::post('emails/send', 'EmailsController@send');


Route::resource('blog/tag', 'Blog\TagController', ['except' => 'show']);
Route::resource('blog/posts', 'Blog\PostsController');

Route::get('/admin/login','Adminauth\AuthController@showLoginForm');
Route::post('/admin/login','Adminauth\AuthController@login');

Route::get('admin/register', 'Adminauth\AuthController@showRegistrationForm');
Route::post('admin/register', 'Adminauth\AuthController@register');
Route::group(['middleware' => ['admin']], function () {
    //Login Routes...
    Route::get('/admin/logout','Adminauth\AuthController@logout');
	
    // Registration Routes...
    

    Route::get('/admin', 'Admin\Employee@index');
});

Route::get('adminauth/email-auth/{token}', [
    'as' => 'adminauth.email-auth',
    'uses' => 'Adminauth\AuthController@authenticateEmail'
]);