<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // イベントごとの参加者数
        $participationData = DB::table('event_user')
            ->join('events', 'event_user.event_id', '=', 'events.id')
            ->where('event_user.is_canceled', false)
            ->select('events.title', DB::raw('COUNT(*) as count'))
            ->groupBy('events.title')
            ->get();

        //キャンセル
        $cancelStats = DB::table('event_user')
            ->selectRaw("SUM(CASE WHEN is_canceled = false THEN 1 ELSE 0 END) as joined")
            ->selectRaw("SUM(CASE WHEN is_canceled = true THEN 1 ELSE 0 END) as canceled")
            ->first();

            return view('admin.dashboard', compact('participationData', 'cancelStats'));
    }
}
