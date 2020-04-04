# 簡易購物車 (藍新金流)

## 安裝套件
```
$ composer install
```

## 產生設定檔
```
$ cp .env.example .env
```

## 產生金鑰與修改設定
```
$ php artisan key:generate
$ php artisan jwt:secret

$ vim .env

DB_DATABASE={db_name}
DB_USERNAME={db_user}
DB_PASSWORD={db_password}

QUEUE_CONNECTION=redis
```

## 資料表遷移
```
$ php artisan migrate
```

## 隊列監聽
```
$ php artisan queue:work --tries=3 --sleep=5
```