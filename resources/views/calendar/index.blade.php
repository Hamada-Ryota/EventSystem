<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: bold;">
            イベントカレンダー
        </h2>
    </x-slot>
    <form id="filter-form">
        <label for="category">カテゴリ:</label>
        <select id="category" name="category">
            <option value="">すべて</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="date">日付:</label>
        <input type="date" id="date" name="date">

        <button type="submit">フィルター</button>
    </form>

    <div id="app">
        <calendar-component></calendar-component>
    </div>
</x-app-layout>
