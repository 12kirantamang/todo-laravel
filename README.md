# todo-laravel（環境構築用リポジトリ）

LaravelでTODOアプリを作る教材（`documents/laravel/todo-app`）の **step04「TODO一覧画面の作成」から開発を始められる状態** にした環境構築用リポジトリです。

教材の step01〜03（概要・環境構築・Laravelについて）が終わった状態と同じものが、すぐに用意できます。

## 含まれているもの

| 項目 | 内容 |
| --- | --- |
| `docker-compose.yml` / `php/Dockerfile` | PHP 8.2 + Apache、MySQL 8.0、phpMyAdmin |
| `src/` | Laravel 12 の初期状態（`composer create-project` 直後と同じ。`vendor/` と `.env` は含まない） |
| `setup.sh` | 環境構築を自動で行うスクリプト |

教材の step02 で手作業で作る `docker-compose.yml`・`php/Dockerfile`・Laravel プロジェクトは、このリポジトリに**作成済み**です。
step04 以降の変更（ルート・コントローラー・ビューなど）は含まれていません。教材に沿って自分で書いていきます。

## 動作環境

- Ubuntu 22.04 / 24.04（WSL2 上の Ubuntu も可）
- Docker Engine 24 以上 と `docker compose`（インストール手順は教材 step02 を参照）
- ブラウザ

> WSL2 の場合は、このリポジトリを Windows 側（`/mnt/c/...`）ではなく **Ubuntu 側のホームディレクトリ（`~/`）の下**に置いてください。

## セットアップ

```bash
git clone <このリポジトリのURL> todo-laravel
cd todo-laravel
./setup.sh
```

`setup.sh` は次の処理をします（何度実行してもかまいません）。

1. `.env`（docker compose 用）に自分のユーザーID・グループIDを書き出す
2. `docker compose up -d --build` でコンテナを起動
3. コンテナ内で `composer install`、Laravel の `.env` 作成、`php artisan key:generate`、`php artisan migrate`

完了したら、ブラウザで確認します。

| URL | 表示 |
| --- | --- |
| http://localhost:8000 | Laravel の Welcome 画面 |
| http://localhost:8080 | phpMyAdmin |

Welcome 画面が表示されれば、step04 に進めます。

### 手動でセットアップする場合

```bash
printf "HOST_UID=%s\nHOST_GID=%s\n" "$(id -u)" "$(id -g)" > .env
docker compose up -d --build

docker compose exec -u appuser app bash
# ↓ ここからコンテナ内
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
exit
```

## 開発の進め方

- コードの編集は **Ubuntu 側で `src/` を開いて**行います（VS Code など）。
- artisan や composer のコマンドは、コンテナに入って実行します。

```bash
docker compose exec -u appuser app bash
```

| やりたいこと | コマンド |
| --- | --- |
| 起動 | `docker compose up -d` |
| 停止 | `docker compose stop` |
| 状態確認 | `docker compose ps` |
| ログ確認 | `docker compose logs -f app` |
| 作り直し（DBのデータも削除） | `docker compose down -v` |

## ディレクトリ構成

```
todo-laravel/
├── docker-compose.yml
├── php/
│   └── Dockerfile
├── setup.sh
├── .env.example      ← docker compose 用（UID / GID）
└── src/              ← Laravel 12
    ├── .env.example  ← Laravel 用
    └── ...
```

`.env` は2種類あります（どちらも Git 管理外）。

| ファイル | 用途 |
| --- | --- |
| `./.env` | docker compose 用（ユーザーID） |
| `./src/.env` | Laravel 用（アプリ名・DB接続など） |

## つまずいたら

教材 step02 の「つまずきポイント」を参照してください。よくあるもの：

- `permission denied ... docker.sock` → `docker` グループに入っていない。`sudo usermod -aG docker $USER` のあと、ログインし直す
- `port is already allocated` → 8000 / 8080 を使っているアプリを止めるか、`docker-compose.yml` のポート番号を変える
- `src/` のファイルを保存できない → `sudo chown -R $USER:$USER src`
