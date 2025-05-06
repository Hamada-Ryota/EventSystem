<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: bold;">
            イベントカレンダー
        </h2>
    </x-slot>
    <form method="GET" style="margin: 20px auto; max-width: 800px;">
        <label>カテゴリ:</label>
        <select name="category" onchange="this.form.submit()">
            <option value="">すべて</option>
            @foreach (\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </form>
    <div id="app">
        <calendar-component></calendar-component>
    </div>
</x-app-layout>
