<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function events()
    {
        $userId = Auth::id();

        $events = DB::table('event_user')
            ->join('events', 'event_user.event_id', '=', 'events.id')
            ->where('event_user.user_id', $userId)
            ->where('event_user.is_canceled', false)
            ->select('events.title', 'events.date', 'events.location', 'event_user.registered_at')
            ->get();

        return view('mypage.events', compact('events'));
    }
}
