# @マイグレーション設計 【roles テーブル】

| カラム名 | 型 | 属性 |
| --- | --- | --- |
| id | increments | 主キー |
| name | string(50) | ユニーク |
| description | string(255) | NULL可 |
| timestamps | - | created_at, updated_at 自動生成 |

Laravel用に書くと、こんな感じになります👇

```php

Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name', 50)->unique();
    $table->string('description', 255)->nullable();
    $table->timestamps();
});

```