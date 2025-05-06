<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント詳細
        </h2>
    </x-slot>

    <a href="{{ route('mypage.events') }}" style="margin-right: 10px;">参加イベント</a>

    <div style="margin-top: 20px;">
        <a href="{{ route('events.export', $event->id) }}"
            style="background-color: #007bff; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;">
            CSVエクスポート
        </a>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-xl font-bold mb-4">{{ $event->title }}</p>
                <p><strong>開催日:</strong> {{ $event->date }}</p>
                <p><strong>場所:</strong> {{ $event->location }}</p>
                <p><strong>詳細:</strong> {{ $event->detail }}</p>
                <p><strong>定員:</strong> {{ $event->capacity }} 人</p>

                {{-- 現在の参加人数と満員判定 --}}
                @php
                    $currentParticipants = DB::table('event_user')
                        ->where('event_id', $event->id)
                        ->where('is_canceled', false)
                        ->count();

                    $isFull = $currentParticipants >= $event->capacity;
                @endphp

                <p><strong>現在の参加人数:</strong> {{ $currentParticipants }} 人</p>

                {{-- ログインしている一般ユーザーのみボタン表示 --}}
                @if (auth()->check() && auth()->user()->role_id === 1)
                    @php
                        $joined = DB::table('event_user')
                            ->where('event_id', $event->id)
                            ->where('user_id', auth()->id())
                            ->where('is_canceled', false)
                            ->exists();
                    @endphp

                    @if ($joined)
                        {{-- ✅ まず「参加済み」なら無条件でキャンセルボタンを出す --}}
                        <form action="{{ route('events.cancel', $event->id) }}" method="POST"
                            style="margin-top: 16px;">
                            @csrf
                            <button type="submit"
                                style="background-color: red; color: white; font-weight: bold; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                                キャンセルする
                            </button>
                        </form>
                    @elseif ($isFull)
                        {{-- ❌ それ以外で満員なら参加できない --}}
                        <p class="text-red-500 font-bold mt-4">満員のため参加できません</p>
                    @else
                        {{-- ✅ 空きがあれば参加できる --}}
                        <form action="{{ route('events.join', $event->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                参加する
                            </button>
                        </form>
                    @endif
                @endif

                {{-- ▼ 主催者だけ参加者リストを表示する --}}
                @if (auth()->check() && auth()->user()->role_id === 2)
                    <h3 style="margin-top: 30px; font-size: 20px; font-weight: bold;">参加者一覧</h3>

                    @if ($participants->isEmpty())
                        <p>まだ参加者はいません。</p>
                    @else
                        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #ccc; padding: 8px;">名前</th>
                                    <th style="border: 1px solid #ccc; padding: 8px;">参加登録日時</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($participants as $participant)
                                    <tr>
                                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $participant->name }}</td>
                                        <td style="border: 1px solid #ccc; padding: 8px;">
                                            {{ \Carbon\Carbon::parse($participant->registered_at)->format('Y-m-d H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endif
                @if (auth()->check())
                    <form action="{{ route('events.reviews.store', $event) }}" method="POST">
                        @csrf
                        <h3>レビューを投稿</h3>

                        <label>評価（1〜5）:</label>
                        <select name="rating" required>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} ⭐</option>
                            @endfor
                        </select>

                        <br>

                        <label>コメント:</label><br>
                        <textarea name="comment" rows="3" style="width:100%"></textarea>

                        <br><br>
                        <button type="submit">投稿する</button>
                    </form>
                @endif

                @if ($event->reviews->count())
                    <h3>平均評価</h3>
                    <p>
                        {{ str_repeat('⭐', floor($event->averageRating())) }}
                        {{ $event->averageRating() }} / 5
                    </p>
                @endif
                
                @if ($event->reviews->count())
                    <h3>レビュー一覧</h3>
                    <ul>
                        @foreach ($event->reviews as $review)
                            <li style="margin-bottom: 10px;">
                                <strong>{{ $review->user->name }}</strong>：
                                {{ str_repeat('⭐', $review->rating) }}（{{ $review->rating }}/5）
                                <br>
                                <small>{{ $review->created_at->format('Y年m月d日 H:i') }}</small><br>
                                <div>{{ $review->comment }}</div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>まだレビューはありません。</p>
                @endif
                @foreach ($event->reviews as $review)
                    <li style="margin-bottom: 10px;">
                        <strong>{{ $review->user->name }}</strong>：
                        {{ str_repeat('⭐', $review->rating) }}（{{ $review->rating }}/5）<br>
                        <small>{{ $review->created_at->format('Y年m月d日 H:i') }}</small><br>
                        <div>{{ $review->comment }}</div>

                        @if (auth()->id() === $review->user_id)
                            {{-- 編集フォーム --}}
                            <form action="{{ route('reviews.update', $review) }}" method="POST"
                                style="margin-top: 10px;">
                                @csrf
                                @method('PATCH')
                                <label>評価:</label>
                                <select name="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}"
                                            {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }} ⭐
                                        </option>
                                    @endfor
                                </select>
                                <br>
                                <label>コメント:</label><br>
                                <textarea name="comment" rows="2">{{ $review->comment }}</textarea><br>
                                <button type="submit">更新</button>
                            </form>

                            {{-- 削除ボタン --}}
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                onsubmit="return confirm('削除しますか？');" style="margin-top: 5px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color:red;">削除</button>
                            </form>
                        @endif
                    </li>
                @endforeach
                <div class="mt-4">
                    <a href="{{ route('events.index') }}" class="text-blue-500 hover:underline">一覧に戻る</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
