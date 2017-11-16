@extends('layouts.app')

@section('content')
<header>
    <a href="{{url('/home')}}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-th-large"></span></a>
</header>
<div class="container">
    <div class="row">
        <div class="col-md-2 text-center">
            レベル<br>
            <span class="level">{{$level}}</span>
        </div>
        <div class="col-md-10">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                    style="width: {{$summary % 100}}%;"
                >
                    {{$summary % 100}}
                </div>
            </div>
            @if ($level > $yesterdayLevel)
            <div class="text-center"><img src="{{asset('img/levelup.png')}}"></div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                @foreach ($weeklySummary as $week)
                <tr>
                    <th width="30%">{{$week->start_date}}〜{{$week->end_date}}</th>
                    <td width="70%">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ceil(100 * $week->cnt / $weeklyMax)}}%;"
                            >
                                {{$week->cnt}}
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
