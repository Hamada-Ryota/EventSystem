# PHP公式イメージ（Laravel 11 + PHP 8.2 対応）
FROM php:8.2-fpm

# システムパッケージのインストール（Node.js, SQLite, npm, 必要な拡張）
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libzip-dev \
    zip \
    libonig-dev \
    sqlite3 \
    libsqlite3-dev \
    npm \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip

# Node.js 18 をインストール（npmも含まれる）
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリを設定
WORKDIR /var/www

# プロジェクトファイルをコピー
COPY . .

# 依存関係インストール + ビルド
RUN composer install --no-dev --optimize-autoloader && \
    npm install && \
    npm run build && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# SQLiteファイルの初期化
RUN touch database/database.sqlite

# ポート公開（Laravel開発サーバー）
EXPOSE 8000

# 起動コマンド（Renderで使用）
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
