<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class PagesController extends Controller
{
    public function home()
    {
        $arrayMessages = Message::latest()->paginate(10);
        
        return view('welcome',['messages' => $arrayMessages]);
    }    
}
