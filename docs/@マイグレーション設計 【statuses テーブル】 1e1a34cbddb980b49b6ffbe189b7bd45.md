# @マイグレーション設計 【statuses テーブル】

| カラム名 | 型 | 属性 |
| --- | --- | --- |
| id | increments | 主キー |
| name | string(50) | 必須・ユニーク |
| timestamps | - | created_at, updated_at 自動生成 |

---

Laravel用に書くと👇

```php

Schema::create('statuses', function (Blueprint $table) {
    $table->id();
    $table->string('name', 50)->unique();
    $table->timestamps();
});

```

> 公開ステータス（例：「公開」「非公開」「限定公開」）を管理するテーブルです！
>