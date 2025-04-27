<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('イベント詳細') }}
        </h2>
    </x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1>{{ $event->title }}</h1>

                <p><strong>開催日：</strong>{{ $event->date }}</p>
                <p><strong>場所：</strong>{{ $event->location }}</p>
                <p><strong>詳細：</strong>{{ $event->detail }}</p>
                <p><strong>定員：</strong>{{ $event->capacity }}人</p>

                <p><a href="{{ route('events.index') }}">一覧に戻る</a></p>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
