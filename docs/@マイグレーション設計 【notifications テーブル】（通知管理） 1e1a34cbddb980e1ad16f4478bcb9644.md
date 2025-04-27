# @マイグレーション設計 【notifications テーブル】（通知管理）

| カラム名 | 型 | 属性 |
| --- | --- | --- |
| id | increments | 主キー |
| user_id | foreign key (users.id) | 必須（誰への通知か） |
| type | string(100) | 通知の種類（例：イベント登録完了、リマインダー） |
| data | json | 通知の詳細情報（イベント名、日時など） |
| read_at | timestamp | 既読日時（NULLなら未読） |
| created_at | datetime | 作成日時 |
| timestamps | - | created_at, updated_at 自動生成 |

---

Laravel用に書くと👇

```php

Schema::create('notifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->string('type', 100);
    $table->json('data');
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});

```