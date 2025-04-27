<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('イベント一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div style="color: green; font-weight: bold; margin-bottom: 20px;">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div style="margin-bottom: 20px;">
                        <a href="{{ route('events.create') }}"
                            style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                            新しいイベントを作成する
                        </a>
                    </div>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>タイトル</th>
                                <th>開催日</th>
                                <th>場所</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->id }}</td>
                                    <td><a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a></td>
                                    <td>{{ $event->date }}</td>
                                    <td>{{ $event->location }}</td>
                                    <td>
                                        <div class="flex space-x-4 justify-center">
                                            {{-- 編集リンク --}}
                                            <a href="{{ route('events.edit', $event->id) }}"
                                                class="text-yellow-500 hover:underline">
                                                編集
                                            </a>

                                            {{-- 削除リンク --}}
                                            <a href="{{ route('events.destroy', $event->id) }}"
                                                onclick="event.preventDefault(); if (confirm('本当に削除しますか？')) { document.getElementById('delete-form-{{ $event->id }}').submit(); }"
                                                class="text-red-500 hover:underline">
                                                削除
                                            </a>

                                            {{-- 削除用の隠しフォーム --}}
                                            <form id="delete-form-{{ $event->id }}"
                                                action="{{ route('events.destroy', $event->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
