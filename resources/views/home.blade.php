@extends('layouts.app')

@section('content')
<div id="action-panels">
@foreach ($actions as $actionId => $action)
    <a href="#" data-action="{{$actionId}}" data-enabled="{{$enabledActions->search($actionId) === false ? 'false' : 'true'}}">
        <div class="panel panel-default action-panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{$action['name']}}</h3>
            </div>
            <div class="panel-body">

            </div>
        </div>
    </a>
@endforeach
</div>
@endsection
