# @マイグレーション設計 【oauth_providers テーブル】（OAuthログイン管理）

| カラム名 | 型 | 属性 |
| --- | --- | --- |
| id | increments | 主キー |
| user_id | foreign key (users.id) | 必須 |
| provider_name | string(50) | プロバイダ名（例：google） |
| provider_id | string(100) | プロバイダ側ユーザーID |
| timestamps | - | created_at, updated_at 自動生成 |

---

Laravel用に書くと👇

```php

Schema::create('oauth_providers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->string('provider_name', 50);
    $table->string('provider_id', 100);
    $table->timestamps();
});

```