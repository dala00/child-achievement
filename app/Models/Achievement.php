<?php

namespace App\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'child_achievements';
    protected $guarded = ['id'];

    public static function getSummary($userId, $limitDate = null)
    {
        $query = self::where('user_id', $userId);
        if ($limitDate) {
            $query->where('action_date', '<=', $limitDate);
        }
        return $query->where('enabled', true)
            ->count();
    }

    public static function getLevel($summary)
    {
        return floor($summary / 100) + 1;
    }

    public static function getWeeklySummary($userId)
    {
        $dateSummary = self::select(DB::raw("COUNT(*) AS cnt, action_date"))
            ->where('user_id', $userId)
            ->where('enabled', true)
            ->orderBy('action_date')
            ->groupBy('action_date')
            ->get();

        $weeklySummary = [];
        $currentWeek = null;
        foreach ($dateSummary as $row) {
            if ($currentWeek && $currentWeek->end_date < $row->action_date) {
                $weeklySummary[] = $currentWeek;
                $currentWeek = null;
            }
            if (!$currentWeek) {
                $currentWeek = new self;
                $date = new Carbon($row->action_date);
                $date->subDay($date->dayOfWeek);
                $currentWeek->start_date = $date->format('Y-m-d');
                $currentWeek->end_date = $date->addDay(6)->format('Y-m-d');
                $currentWeek->cnt = 0;
            }
            $currentWeek->cnt += $row->cnt;
        }
        if ($currentWeek) {
            $weeklySummary[] = $currentWeek;
        }

        return collect(array_reverse($weeklySummary));
    }
}
