<?php

namespace App\Http\Controllers;

use App\User;
use App\Conversation;
use App\PrivateMessage;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show($username)
    {        
        //throw new \Exception("Simulando un error pendejo");
        $user = $this->fingByUsername($username);
        return view('users.show',['user'=> $user]);
    }
    
    public function profile(Request $request)
    {
        return redirect("/".$request->user()->username);
    }
    
    public function follows($username)
    {
        $user = $this->fingByUsername($username);
        return view('users.follows',['user'=> $user, 'follows' => $user->follows]); 
    }
    
    public function followers($username)
    {
        $user = $this->fingByUsername($username);
        return view('users.follows',['user'=> $user, 'follows' => $user->followers]); 
    }
    
    public function follow($username, Request $request)
    {        
        $user = $this->fingByUsername($username);
        $me = $request->user();
        $me->follows()->attach($user);
        return redirect("/$username")->withSuccess("Usuario seguido!");        
    }
    
    public function unfollow($username, Request $request)
    {        
        $user = $this->fingByUsername($username);
        $me = $request->user();
        $me->follows()->detach($user);
        return redirect("/$username")->withSuccess("Usuario no seguido!");        
    }
    
    
    
    public function sendPrivateMessage($username, Request $request)
    {
        $user = $this->fingByUsername($username);

        $me = $request->user();
        $message = $request->input('message');

        $conversation = Conversation::between($me, $user);
        //dd($conversation->id); die;
        $privateMessage = PrivateMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => $me->id,
            'message' => $message,
        ]);

        return redirect('/conversations/'.$conversation->id);
    }

    public function showConversation(Conversation $conversation)
    {        
        $conversation->load('users', 'privateMessages');
        
        return view('users.conversation', [
            'conversation' => $conversation,
            'user' => auth()->user(),
        ]);
    }        
    
    private function fingByUsername($username)
    {
        return User::where('username',$username)->firstOrFail();
    }
}
