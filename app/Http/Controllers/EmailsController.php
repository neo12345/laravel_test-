<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;
use Session;

class EmailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('emails.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function send(Request $request)
    {
        $this->validate($request, [
            'receiver' => 'required|email',
            'replyTo' => 'required|email',
            'subject' => 'required',
            'body' => 'required'
        ]);
        
        $body = array(
            'body' => $request->body
            );
        $data = array(
            'sender' => config('mail.username'),
            'name' => $request->name,
            'receiver' => $request->receiver,
            'replyTo' => $request->replyTo,
            'subject' => $request->subject
        );
        Mail::send('emails.welcome', $body, function($message) use ($data) {
            $message->from($data['sender'], $data['name'])
                ->subject($data['subject'])
                ->to($data['receiver'])
                ->replyTo($data['replyTo'], $data['name']);

        });
        
        Session::flash('flash_message', 'Your email has been send successfully!');
        
        return redirect()->route('emails.index');
    }
}
