<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ユーザー編集') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">名前</label>
                        <div>{{ $user->name }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">メールアドレス</label>
                        <div>{{ $user->email }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">ロール</label>
                        <select name="role_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" @if ($user->role_id == $role->id) selected @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            更新する
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
