<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * カテゴリ一覧表示
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
    /**
     * 新しいカテゴリを登録するフォームを表示する
     */
    public function create()
    {
        return view('admin.categories.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション（入力チェック）
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        // データベースに新しいカテゴリを保存
        Category::create($validated);

        // 登録完了後、一覧ページにリダイレクト
        return redirect()->route('admin.categories.index')->with('success', 'カテゴリを登録しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        // 更新処理
        $category->update($validated);

        // 更新完了後、一覧にリダイレクト
        return redirect()->route('admin.categories.index')->with('success', 'カテゴリを更新しました！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'カテゴリを削除しました！');
    }
    }
