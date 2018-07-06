
@extends('layouts.app')

@section('content')
<h1>Conversación con {{ $conversation->users->except($user->id)->implode('name',', ') }}</h1>

<div class="card">
    @foreach($conversation->privateMessages as $message)
    <div class="card-header">
        {{$message->user->name}} dijo...
    </div>
    <div class="card-block">        
            {{$message->message}}        
    </div>
    <div class="card-footer">
            {{$message->created_at}}        
    </div><br/>
    @endforeach
</div>

@endsection