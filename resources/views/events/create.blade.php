<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('新しいイベント作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('events.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label>タイトル*</label><br>
                            <input type="text" name="title" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-4">
                            <label>開催日*</label><br>
                            <input type="date" name="date" value="{{ old('date') }}" required>
                        </div>

                        <div class="mb-4">
                            <label>開催時間（例：14:00～16:00）</label><br>
                            <input type="text" name="time" value="{{ old('time') }}">
                        </div>

                        <div class="mb-4">
                            <label>場所</label><br>
                            <input type="text" name="location" value="{{ old('location') }}">
                        </div>

                        <div class="mb-4">
                            <label>カテゴリ</label><br>
                            <select name="category_id">
                                <option value="">選択してください</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label>詳細説明</label><br>
                            <textarea name="detail">{{ old('detail') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label>定員</label><br>
                            <input type="number" name="capacity" value="{{ old('capacity') }}" min="0">
                        </div>

                        <div class="mb-4">
                            <label>公開ステータス*</label><br>
                            <select name="status_id" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit">イベントを登録する</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
