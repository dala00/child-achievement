@extends('layouts.app')

@section('content')
<div id="login-container">
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{$googleLoginUrl}}" class="btn btn-primary">Googleログイン</a>
        </div>
    </div>
</div>
@endsection
