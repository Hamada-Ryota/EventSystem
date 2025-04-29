<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント詳細
        </h2>
    </x-slot>

    <a href="{{ route('mypage.events') }}" style="margin-right: 10px;">参加イベント</a>
    
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
                        <form action="{{ route('events.cancel', $event->id) }}" method="POST" style="margin-top: 16px;">
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

                <div class="mt-4">
                    <a href="{{ route('events.index') }}" class="text-blue-500 hover:underline">一覧に戻る</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
