<?php

namespace App\Http\Controllers;

use App\Models\Event;
use \App\Models\Category;
use \App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Notifications\EventJoinedNotification;
use App\Notifications\EventCanceledNotification;
use App\Notifications\EventReminder;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();

        foreach ($events as $event) {
            $event->joined_count = DB::table('event_user')
                ->where('event_id', $event->id)
                ->where('is_canceled', false)
                ->count();
        }

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
        // 参加者リスト取得（キャンセルしていない人だけ）
        $participants = DB::table('event_user')
            ->join('users', 'event_user.user_id', '=', 'users.id')
            ->where('event_user.event_id', $event->id)
            ->where('event_user.is_canceled', false)
            ->select('users.name', 'event_user.registered_at')
            ->get();

        return view('events.show', compact('event', 'participants'));
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

    //一般ユーザーの参加登録処理
    public function join($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();

        // すでに登録しているか確認
        $alreadyJoined = DB::table('event_user')
            ->where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->where('is_canceled', false)
            ->exists();

        if ($alreadyJoined) {
            return redirect()->back()->with('error', 'すでに参加登録済みです。');
        }

        // 登録処理
        DB::table('event_user')->insert([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'registered_at' => Carbon::now(),
            'is_canceled' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 通知送信（1回だけ）
        $user->notify(new EventJoinedNotification($event));

        return redirect()->back()->with('success', 'イベントに参加登録しました！');
    }

    //一般ユーザーでイベントキャンセル
    public function cancel($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();

        DB::table('event_user')
            ->where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->where('is_canceled', false)
            ->update([
                'is_canceled' => true,
                'canceled_at' => now(),
                'updated_at' => now(),
            ]);

        $user->notify(new EventCanceledNotification($event->title));

        return redirect()->back()->with('success', '参加をキャンセルしました。');
    }

    public function getEvents(Request $request)
    {
        $query = Event::query();

        // カテゴリでフィルター
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 開始日フィルター
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        // 終了日フィルター
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // 場所フィルター（部分一致）
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $events = $query->get()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => Carbon::parse($event->date)->toIso8601String(),
                'allDay' => true,
                'url' => route('events.show', $event->id),
            ];
        });

        return response()->json($events, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function exportCsv(Event $event): StreamedResponse
    {
        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=event_{$event->id}_participants.csv",
        ];

        $callback = function () use ($event) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM 追加（Excel 用）
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // ヘッダー行
            fputcsv($handle, ['名前', '登録日時']);

            // データ行
            $participants = DB::table('event_user')
                ->join('users', 'event_user.user_id', '=', 'users.id')
                ->where('event_user.event_id', $event->id)
                ->where('event_user.is_canceled', false)
                ->select('users.name', 'event_user.registered_at')
                ->get();

            foreach ($participants as $participant) {
                fputcsv($handle, [$participant->name, $participant->registered_at]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function upcomingEvents()
    {
        $events = Event::upcoming()->get();
        return view('events.upcoming', compact('events'));
    }
}
