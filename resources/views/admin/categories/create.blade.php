<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('カテゴリ作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name">カテゴリ名*</label><br>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                        </div>

                        <button type="submit">登録する</button>
                    </form>

                    <p class="mt-4">
                        <a href="{{ route('admin.categories.index') }}">カテゴリ一覧に戻る</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
