<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            通知一覧
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        @php $shown = false; @endphp

        @foreach ($notifications as $notification)
            @if (!empty($notification->data['message']))
                @php $shown = true; @endphp
                <div style="margin-bottom: 12px; padding: 10px; background: #f9f9f9; border: 1px solid #ddd;">
                    <strong>{{ $notification->data['message'] }}</strong>
                    <br>
                    <small>{{ $notification->created_at->format('Y-m-d H:i') }}</small>
                </div>
            @endif
        @endforeach

        @unless($shown)
            <p>通知はありません。</p>
        @endunless
    </div>
</x-app-layout>
