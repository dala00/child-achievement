<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $enabledActions = Achievement::where('user_id', $user->id)
            ->where('action_date', Carbon::now()->format('Y-m-d'))
            ->where('enabled', true)
            ->pluck('action');
        $actions = config('actions');
        return view('home', compact('user', 'enabledActions', 'actions'));
    }

    public function toggle(Request $request)
    {
        $user = Auth::user();
        $action = $request->input('action');
        $today = Carbon::now()->format('Y-m-d');
        $achievement = Achievement::where('user_id', $user->id)
            ->where('action_date', $today)
            ->where('action', $action)
            ->first();
        if (!$achievement) {
            $achievement = new Achievement;
            $achievement->user_id = $user->id;
            $achievement->action_date = $today;
            $achievement->action = $action;
        }
        $achievement->enabled = $request->input('status');
        $achievement->save();
    }

    /**
     * Show summary.
     *
     * @return \Illuminate\Http\Response
     */
    public function summary()
    {
        $user = Auth::user();
        $yesterday = Carbon::now()->subDay()->format('Y-m-d');
        $data = [
            'summary' => Achievement::getSummary($user->id),
            'yesterdaySummary' => Achievement::getSummary($user->id, $yesterday),
            'weeklySummary' => Achievement::getWeeklySummary($user->id),
        ];
        $data['level'] = Achievement::getLevel($data['summary']);
        $data['yesterdayLevel'] = Achievement::getLevel($data['yesterdaySummary']);
        $data['weeklyMax'] = $data['weeklySummary']->map(function ($summary) {
            return $summary->cnt;
        })->max();
        return view('home.summary', $data);
    }
}
