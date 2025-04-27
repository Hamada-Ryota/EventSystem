# @マイグレーション設計 【users テーブル】

| カラム名 | 型 | 属性 |
| --- | --- | --- |
| id | increments | 主キー |
| name | string(100) | 必須 |
| email | string(255) | 必須・ユニーク |
| email_verified_at | timestamp | NULL可 |
| password | string(255) | 必須 |
| role_id | foreign key (roles.id) | 必須 |
| remember_token | string(100) | NULL可（Laravel認証用） |
| timestamps | - | created_at, updated_at 自動生成 |

---

Laravel用に書くと、こうなります👇

```php

Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name', 100);
    $table->string('email', 255)->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password', 255);
    $table->foreignId('role_id')->constrained('roles');
    $table->rememberToken();
    $table->timestamps();
});

```

> foreignId('role_id')->constrained('roles') で、roles.id を外部キー参照する形になってます！
> 

---

# 📌 ここまででポイント確認

- **role_id** は必ず指定する（デフォルト：一般ユーザー）
- **email** は重複禁止（ユニーク）
- **remember_token** はLaravelのセッション保持機能で使う
- パスワードはハッシュ化して保存する前提