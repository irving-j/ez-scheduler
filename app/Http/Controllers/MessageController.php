<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    /**
     * Show the message details for the given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function get($id)
    {
        return view('message.message', ['message' => Message::findOrFail($id)]);
    }

    /**
     * Show the message details for the given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function get_messages()
    {
        //TODO: get the employee id from the session the right way
        return view('message.message', 
        	['message' => Message::where('employee_id', 
        		$session['employee_id'])
               ->orderBy('created_in', 'desc')
               ->get()]);
    }

    public function delete($id)
    {
    	$flight = Message::findOrFail($id);
		$flight->delete();
    }

    public function store(Request $request)
    {
        $message = Message::create(array(
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            ));
        
        $message->recipients()->attach($request->input('recipient'));
        
        return get($message->id);
    }
}
