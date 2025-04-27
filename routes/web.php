<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//一般ユーザー用ログイン先
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    });
});

//イベント主催者用ログイン先
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/events', function () {
        return view('events.index');
    });
});

//管理者用ログイン先
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('/admin/categories', function () {
        return view('admin.cateogries');
    });
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
});

//イベント一覧表示用
Route::get('/events', [EventController::class, 'index'])->middleware('auth')->name('events.index');
//作成画面を表示（createメソッド）
Route::get('/events/create', [EventController::class, 'create'])->middleware('auth')->name('events.create');
//登録処理をする（storeメソッド）
Route::post('/events', [EventController::class, 'store'])->middleware('auth')->name('events.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//イベント詳細画面
Route::get('/events/{event}', [EventController::class, 'show'])->middleware('auth')->name('events.show');
//イベント編集画面
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->middleware('auth')->name('events.edit');
//イベントデータの更新
Route::put('/events/{event}', [EventController::class, 'update'])->middleware('auth')->name('events.update');
//イベントデータの削除
Route::delete('/events/{event}', [EventController::class, 'destroy'])->middleware('auth')->name('events.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
