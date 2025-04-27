# @マイグレーション設計 【check_ins テーブル】（チェックイン管理）

| カラム名 | 型 | 属性 |
| --- | --- | --- |
| id | increments | 主キー |
| event_id | foreign key (events.id) | 必須 |
| user_id | foreign key (users.id) | 必須 |
| checked_in_at | timestamp | チェックイン日時 |
| device_info | string(255) | チェックインした端末情報（例：iPhone 15, Pixel 8） |
| timestamps | - | created_at, updated_at 自動生成 |

---

Laravel用に書くと👇

```php

Schema::create('check_ins', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->timestamp('checked_in_at');
    $table->string('device_info', 255)->nullable();
    $table->timestamps();
});

```