<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Auth;
use App\Admin;
use Event;
use App\Events\SendMail;

class Employee extends Controller
{
	public function __construct(){
        $this->middleware('admin');
   }
	
	public function index(){
        Event::fire(new SendMail(2));
		return view('admin.home');
    }
}