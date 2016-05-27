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

Route::get('/', 'ComicsController@index'); 

Route::auth();

Route::get('/home', 'ComicsController@index');

Route::model('pages', 'Pages');
Route::model('chapters', 'Chapters');
Route::model('comics', 'Comics');
Route::model('categories', 'Categories');

Route::bind('pages', function($value, $route) {
	return App\Pages::whereId($value)->first();
});
Route::bind('chapters', function($value, $route) {
	return App\Chapters::whereName($value)->first();
});
Route::bind('comics', function($value, $route) {
	return App\Comics::whereSlug($value)->first();
});
Route::bind('categories', function($value, $route) {
	return App\Categories::whereSlug($value)->first();
});

Route::resource('categories', 'CategoriesController');

Route::post('comics/{slug}/like',[
    'as' => 'comics.like',
    'uses' => 'ComicsController@like',
]);
Route::resource('comics', 'ComicsController');

Route::resource('comics.chapters', 'ChaptersController');

Route::resource('comments', 'CommentsController');
Route::resource('comment2s', 'Comment2sController');

Route::post('comics/{slug}/chapters/{name}/pages/{id}/updateAjax',[
    'as' => 'comics.chapters.pages.updateAjax',
    'uses' => 'PagesController@updateAjax',
]);
Route::resource('comics.chapters.pages', 'PagesController', ['expect' => 'update']);

Route::get('admin/login','Adminauth\AuthController@showLoginForm');
Route::post('admin/login','Adminauth\AuthController@login');

Route::group(['middleware' => ['admin']], function () {
    //Logout Routes...
    Route::get('admin/logout','Adminauth\AuthController@logout');
	
    // Registration Routes...
    Route::get('admin/register', 'Adminauth\AuthController@showRegistrationForm');
    Route::post('admin/register', 'Adminauth\AuthController@register');
    
    // Administrator's route
    Route::get('/admin', 'Adminauth\AuthController@dashbroad');
    
    Route::get('comics/editCategory/{comics}', [
    'as' => 'comics.editCategory',
    'uses' => 'ComicsController@editCategory']);
    
    Route::put('comics/updateCategory/{comics}', [
    'as' => 'comics.updateCategory',
    'uses' => 'ComicsController@updateCategory']);
});