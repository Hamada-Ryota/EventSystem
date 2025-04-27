# @マイグレーション設計 【reviews テーブル】（イベントレビュー）

| カラム名 | 型 | 属性 |
| --- | --- | --- |
| id | increments | 主キー |
| event_id | foreign key (events.id) | 必須 |
| user_id | foreign key (users.id) | 必須 |
| rating | tinyInteger | 1〜5（必須） |
| comment | text | 任意 |
| created_at | datetime | 投稿日時 |
| timestamps | - | created_at, updated_at 自動生成 |

---

Laravel用に書くと👇

```php

Schema::create('reviews', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->tinyInteger('rating'); // 1～5
    $table->text('comment')->nullable();
    $table->timestamps();
});

```