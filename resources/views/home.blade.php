@extends('layouts.app')

@section('content')
<header>
    <a href="{{url('/home/summary')}}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-tasks"></span></a>
</header>
<div id="action-panels">
@foreach ($actions as $actionId => $action)
    <a href="#" data-action="{{$actionId}}" data-enabled="{{$enabledActions->search($actionId) === false ? 'false' : 'true'}}">
        <div class="panel panel-default action-panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{$action['name']}}</h3>
            </div>
            <div class="panel-body">
                <!--<img src="{{asset("img/{$actionId}.png")}}">-->
            </div>
        </div>
    </a>
@endforeach
</div>
@endsection
