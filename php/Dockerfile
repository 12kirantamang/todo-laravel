FROM php:8.2-apache

ARG UID=1000
ARG GID=1000

# 必要なツールと PHP 拡張をインストール
RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Composer（PHP のパッケージ管理ツール）をインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Ubuntu 側のユーザーと同じ UID / GID を持つユーザーを作成
RUN groupadd -o -g ${GID} appuser \
    && useradd -o -m -u ${UID} -g ${GID} -s /bin/bash appuser

# Apache を appuser 権限で動かす（Laravel が storage に書き込めるようにする）
ENV APACHE_RUN_USER=appuser
ENV APACHE_RUN_GROUP=appuser

# DocumentRoot を Laravel の public に変更し、.htaccess を有効化、mod_rewrite を有効化
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && printf 'ServerName localhost\n<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>\n' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel \
    && a2enmod rewrite

WORKDIR /var/www/html
