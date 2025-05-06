<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('カテゴリ管理') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="flex justify-end mb-6">
            <a href="{{ route('admin.categories.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow">
                ＋ 新規カテゴリ追加
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-6">カテゴリ一覧</h1>

                <table class="w-full border-collapse table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left">ID</th>
                            <th class="border px-4 py-2 text-left">カテゴリ名</th>
                            <th class="border px-4 py-2 text-left">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $category->id }}</td>
                                <td class="border px-4 py-2">{{ $category->name }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="inline-block text-blue-600 hover:underline mr-4">
                                        編集
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">
                                            削除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if ($categories->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center py-6 text-gray-500">カテゴリがありません。</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
