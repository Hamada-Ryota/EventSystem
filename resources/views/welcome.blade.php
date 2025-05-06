<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>イベント管理システム</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center py-10 px-6">
        <div class="max-w-3xl w-full bg-white shadow-md rounded-lg p-8">
            <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">イベント管理システム</h1>

            <p class="text-center text-gray-600 mb-8">
                イベントの作成・参加・管理ができる便利なWebアプリです。カレンダー機能やCSV出力、レビュー投稿も搭載！
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                <div class="bg-blue-100 border border-blue-300 rounded p-4">
                    <h2 class="text-lg font-semibold mb-2">📅 カレンダー</h2>
                    <p>イベントスケジュールをカレンダーで確認できます。</p>
                </div>
                <div class="bg-green-100 border border-green-300 rounded p-4">
                    <h2 class="text-lg font-semibold mb-2">👤 マイページ</h2>
                    <p>参加したイベントやプロフィール情報を管理。</p>
                </div>
                <div class="bg-yellow-100 border border-yellow-300 rounded p-4">
                    <h2 class="text-lg font-semibold mb-2">🛠 主催者機能</h2>
                    <p>イベントの作成・編集・参加者管理などが可能。</p>
                </div>
                <div class="bg-red-100 border border-red-300 rounded p-4">
                    <h2 class="text-lg font-semibold mb-2">🔧 管理者機能</h2>
                    <p>ユーザー管理・カテゴリ管理・統計ダッシュボード。</p>
                </div>
            </div>

            @if (Route::has('login'))
                <div class="text-center space-x-4">
                    @auth
                        <a href="{{ route('calendar.index') }}"
                            class="inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
                            カレンダーへ進む
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-block px-6 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
                            ログイン
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-block px-6 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
                                新規登録
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</body>

</html>
