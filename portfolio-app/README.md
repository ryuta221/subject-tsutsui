# app
企業課題

私を読んで


# ローカルにおけるDocker環境の構築手順

## 起動

バックグラウンドで実行

```
docker compose up -d
```

フォアグラウンドで実行

```
docker compose up
```

ビルドして起動

```
docker compose up -d --build
```

## 停止

コンテナの一時停止（コンテナは削除されない）

```
docker compose stop
```

コンテナの停止（コンテナは削除される）

```
docker compose down
```
