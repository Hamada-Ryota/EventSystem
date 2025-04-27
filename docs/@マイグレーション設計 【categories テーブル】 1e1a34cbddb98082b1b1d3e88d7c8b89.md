# @マイグレーション設計 【categories テーブル】

| カラム名 | 型 | 属性 |
| --- | --- | --- |
| id | increments | 主キー |
| name | string(100) | 必須・ユニーク |
| timestamps | - | created_at, updated_at 自動生成 |

---

Laravel用に書くと、こうなります👇

```php

Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name', 100)->unique();
    $table->timestamps();
});

```

> ※ カテゴリ名（例：「技術イベント」「交流会」「セミナー」など）は、管理画面から追加できる想定です。
>