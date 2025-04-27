# @マイグレーション設計 【events テーブル】

| カラム名 | 型 | 属性 |
| --- | --- | --- |
| id | increments | 主キー |
| title | string(255) | 必須 |
| date | date | 必須 |
| time | time | 任意 |
| location | string(255) | 任意 |
| category_id | foreign key (categories.id) | 必須 |
| detail | text | 任意 |
| capacity | integer | 必須 |
| status_id | foreign key (statuses.id) | 必須 |
| organizer_id | foreign key (users.id) | 必須 |
| timestamps | - | created_at, updated_at 自動生成 |

Laravel用に書くと👇

```php

Schema::create('events', function (Blueprint $table) {
    $table->id();
    $table->string('title', 255);
    $table->date('date');
    $table->time('time')->nullable();
    $table->string('location', 255)->nullable();
    $table->foreignId('category_id')->constrained('categories');
    $table->text('detail')->nullable();
    $table->integer('capacity');
    $table->foreignId('status_id')->constrained('statuses');
    $table->foreignId('organizer_id')->constrained('users');
    $table->timestamps();
});

```