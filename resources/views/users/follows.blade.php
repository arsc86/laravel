
@extends('layouts.app')

@section('content')
<h1>{{$user->name}}</h1>

<div class="row">
@foreach($follows as $follow)
<div class="col-6">
    <li><a href="/{{$follow->username}}" class="nav nav-link">{{$follow->username}}</a></li>
</div>
@endforeach
</div>
@endsection