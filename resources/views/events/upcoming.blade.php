<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            開催中イベント一覧
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                @if ($events->isEmpty())
                    <p>現在、開催中のイベントはありません。</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($events as $event)
                            <li class="border-b pb-4">
                                <p class="text-xl font-bold">{{ $event->title }}</p>
                                <p><strong>開催日:</strong> {{ \Carbon\Carbon::parse($event->date)->format('Y年m月d日') }}</p>
                                <p><strong>場所:</strong> {{ $event->location }}</p>
                                <p><strong>カテゴリ:</strong> {{ $event->category->name ?? '未設定' }}</p>
                                <div class="mt-2 mb-2">
                                    <a href="{{ route('events.show', $event->id) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                                        詳細を見る
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
