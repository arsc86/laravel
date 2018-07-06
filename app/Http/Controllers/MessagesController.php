<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Http\Requests\CreateMessageRequest;

class MessagesController extends Controller
{
    public function show(Message $message)
    {
        return view('messages.show',array('message' => $message));
    }
    
    public function create(CreateMessageRequest $request)
    {        
        $user  = $request->user();
        $image = $request->file('image');
        
        $message = Message::create(array('content' => $request->input('message'),
                                         'user_id' => $user->id,                                         
                                         'image' => $image?$image->store('messages','public'):'https://lorempixel.com/600/338?'. mt_rand(0, 1000)
                                         )
                                        );
        
        return redirect('/messages/'.$message->id);
    }        
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $messages = Message::search($query)->get();
        $messages->load('user');
        
        return view('messages.index',['messages' => $messages]);
    }
}
