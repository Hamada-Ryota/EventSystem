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
                        <div class="mb-4 text-green-600 font-bold">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (auth()->check() && auth()->user()->role_id == 2)
                        <div class="mb-4">
                            <a href="{{ route('events.create') }}"
                               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                新しいイベントを作成する
                            </a>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border border-gray-200">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 border">ID</th>
                                    <th class="px-4 py-2 border">タイトル</th>
                                    <th class="px-4 py-2 border">開催日</th>
                                    <th class="px-4 py-2 border">場所</th>
                                    @if (auth()->check() && auth()->user()->role_id == 2)
                                        <th class="px-4 py-2 border">操作</th>
                                    @endif
                                    <th class="px-4 py-2 border">参加者</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border text-center">{{ $event->id }}</td>
                                        <td class="px-4 py-2 border">
                                            <a href="{{ route('events.show', $event->id) }}" class="text-blue-600 hover:underline">
                                                {{ $event->title }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-2 border text-center">{{ $event->date }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $event->location }}</td>
                                        @if (auth()->check() && auth()->user()->role_id == 2)
                                            <td class="px-4 py-2 border text-center">
                                                <div class="flex justify-center space-x-3">
                                                    <a href="{{ route('events.edit', $event->id) }}" class="text-yellow-500 hover:underline">
                                                        編集
                                                    </a>
                                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:underline">
                                                            削除
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                        <td class="px-4 py-2 border text-center">
                                            {{ $event->joined_count }} / {{ $event->capacity }} 人
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
