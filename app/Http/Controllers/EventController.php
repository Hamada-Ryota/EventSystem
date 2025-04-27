<?php

namespace App\Http\Controllers;

use App\Models\Event;
use \App\Models\Category;
use \App\Models\Status;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eventモデルを使って、全イベントデータを取得
        $events = Event::all();

        // events.index というビューにデータを渡して表示
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $statuses = Status::all();

        return view('events.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //入力内容をバリデーションする（ちゃんと正しいデータかチェック）
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer'],
            'detail' => ['nullable', 'string'],
            'capacity' => ['nullable', 'integer', 'min:0'],
            'status_id' => ['required', 'integer'],
        ]);

        //データベースに保存する
        Event::create([
            'title' => $validated['title'],
            'date' => $validated['date'],
            'location' => $validated['location'],
            'detail' => $validated['detail'] ?? '',
            'capacity' => $validated['capacity'],
            'category_id' => 1, //仮で1番目のカテゴリを設定
            'status_id' => 1, //仮で「公開」ステータスを設定
            'organizer_id' => auth()->id(), //ログイン中のユーザーIDを主催者IDとして登録
        ]);

        //登録後、イベント一覧ページにリダイレクトする
        return redirect()->route('events.index')->with('success', 'イベントを登録しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $categories = Category::all();
        $statuses = Status::all();

        return view('events.edit', compact('event', 'categories', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer'],
            'detail' => ['nullable', 'string'],
            'capacity' => ['nullable', 'integer', 'min:0'],
            'status_id' => ['required', 'integer'],
        ]);


        // 更新
        $event->update($validated);

        // 一覧ページにリダイレクト
        return redirect()->route('events.index')->with('success', 'イベントを更新しました！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'イベントを削除しました！');
    }
}
