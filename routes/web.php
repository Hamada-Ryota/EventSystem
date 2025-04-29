<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\MypageController;

Route::get('/', function () {
    return view('welcome');
});

// 一般ユーザー
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/home', fn() => view('home'));
    Route::get('/mypage/events', [MypageController::class, 'events'])->name('mypage.events');
});

// イベント参加/キャンセル
Route::post('/events/{event}/join', [EventController::class, 'join'])->name('events.join');
Route::post('/events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');

// 主催者（今後拡張予定のプレースホルダ）
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/events', fn() => view('events.index'));
});

// 管理者
Route::middleware(['auth', 'role:3'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('events', [AdminEventController::class, 'index'])->name('admin.events.index');
    Route::resource('categories', CategoryController::class)->names('admin.categories');
});

// イベント関連
Route::middleware(['auth'])->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

// プロファイル
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ダッシュボード
Route::get('/dashboard', fn() => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

// 📅 カレンダー（画面とイベントAPI）
Route::get('/calendar', [CalendarController::class, 'index'])->middleware('auth')->name('calendar.index');
Route::get('/api/events', [EventController::class, 'getEvents'])->middleware('auth'); // FullCalendarが使うAPI

require __DIR__.'/auth.php';
