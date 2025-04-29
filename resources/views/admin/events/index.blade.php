<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('イベント管理画面（管理者用）') }}
        </h2>
    </x-slot>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('users.index') }}"
            style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            ユーザー管理へ
        </a>
    </div>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.categories.index') }}"
            style="background-color: #2196F3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            カテゴリ管理へ
        </a>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">タイトル</th>
                            <th class="px-4 py-2">開催日</th>
                            <th class="px-4 py-2">場所</th>
                            <th class="px-4 py-2">カテゴリ</th>
                            <th class="px-4 py-2">ステータス</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td class="border px-4 py-2">{{ $event->id }}</td>
                                <td class="border px-4 py-2">{{ $event->title }}</td>
                                <td class="border px-4 py-2">{{ $event->date }}</td>
                                <td class="border px-4 py-2">{{ $event->location }}</td>
                                <td class="border px-4 py-2">{{ $event->category->name ?? '未設定' }}</td>
                                <td class="border px-4 py-2">{{ $event->status->name ?? '未設定' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
