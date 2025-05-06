<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- 左：ロゴ＋ナビゲーション --}}
            <div class="flex items-center space-x-8">
                {{-- ロゴ --}}
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>

                {{-- ナビゲーションリンク --}}
                <div class="hidden sm:flex space-x-6">
                    {{-- 全ユーザー共通 --}}
                    <x-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.index')">
                        カレンダーを見る
                    </x-nav-link>

                    <x-nav-link :href="route('events.upcoming')" :active="request()->routeIs('events.upcoming')">
                        開催中イベント一覧
                    </x-nav-link>

                    @php
                        $unreadCount = Auth::check() ? Auth::user()->unreadNotifications->count() : 0;
                    @endphp

                    <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')" class="relative">
                        🔔 通知

                        @if ($unreadCount > 0)
                            <span
                                class="absolute top-0 right-0 -mt-2 -mr-3 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5 z-10">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </x-nav-link>

                    {{-- ロール別 --}}
                    @auth
                        @switch(auth()->user()->role_id)
                            @case(1)
                                <x-nav-link :href="route('mypage.events')" :active="request()->routeIs('mypage.events')">
                                    マイページ
                                </x-nav-link>
                            @break

                            @case(2)
                                <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">
                                    主催イベント管理
                                </x-nav-link>
                            @break

                            @case(3)
                                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                    管理者ダッシュボード
                                </x-nav-link>
                                <x-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.index')">
                                    イベント一覧
                                </x-nav-link>
                                <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
                                    カテゴリ管理
                                </x-nav-link>
                                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                                    ユーザー管理
                                </x-nav-link>
                            @break
                        @endswitch
                    @endauth
                </div>
            </div>

            {{-- 右：ユーザー情報・ドロップダウン --}}
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            プロフィール
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                ログアウト
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- ハンバーガー（スマホ） --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- スマホ用ナビ（必要ならロール別表示をここにも追加可能） --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.index')">
                カレンダーを見る
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    プロフィール
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        ログアウト
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
