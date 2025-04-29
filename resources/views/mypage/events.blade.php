<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 20px; font-weight: bold;">マイページ - 参加イベント一覧</h2>
    </x-slot>

    <div style="padding: 20px;">
        @if ($events->isEmpty())
            <p>まだ参加しているイベントはありません。</p>
        @else
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ccc; padding: 8px;">イベント名</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">日付</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">場所</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">登録日時</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $event->title }}</td>
                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $event->date }}</td>
                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $event->location }}</td>
                            <td style="border: 1px solid #ccc; padding: 8px;">{{ \Carbon\Carbon::parse($event->registered_at)->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
