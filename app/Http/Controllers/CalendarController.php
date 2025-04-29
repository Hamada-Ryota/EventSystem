<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CalendarController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // カテゴリ全件取得
        return view('calendar.index', compact('categories')); // ビューへ渡す
    }
}
