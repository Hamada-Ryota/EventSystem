<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventReview;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventReviewController extends Controller
{
    use AuthorizesRequests;
    
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        EventReview::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('events.show', $event)->with('success', 'レビューを投稿しました。');
    }

    public function update(Request $request, EventReview $review)
    {
        $this->authorize('update', $review); // ポリシー制御（後述）

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($request->only('rating', 'comment'));

        return back()->with('success', 'レビューを更新しました。');
    }

    public function destroy(EventReview $review)
    {
        $this->authorize('delete', $review); // ポリシー制御（後述）

        $review->delete();

        return back()->with('success', 'レビューを削除しました。');
    }
}
