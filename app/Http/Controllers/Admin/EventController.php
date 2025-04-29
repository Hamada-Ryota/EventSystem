<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category', 'status')->get(); // カテゴリ・ステータスも一緒に取得

        return view('admin.events.index', compact('events'));
    }
}
