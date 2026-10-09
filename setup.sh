#!/usr/bin/env bash
# 開発環境のセットアップ（何度実行しても安全）
set -euo pipefail
cd "$(dirname "$0")"

# 1. docker compose 用の .env（自分のユーザーID・グループID）
if [ ! -f .env ]; then
  printf "HOST_UID=%s\nHOST_GID=%s\n" "$(id -u)" "$(id -g)" > .env
  echo "→ .env を作成しました"
fi

# 2. コンテナのビルドと起動
docker compose up -d --build

# 3. Laravel の準備（appuser = 自分と同じ UID のユーザーで実行）
docker compose exec -T -u appuser app bash -c '
  set -e
  composer install --no-interaction
  if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
  fi
  touch database/database.sqlite
  php artisan migrate --force
'

echo
echo "✅ セットアップ完了"
echo "   アプリ        : http://localhost:8000"
echo "   phpMyAdmin    : http://localhost:8080"
