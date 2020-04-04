# Laravel 實作簡易購物車 (使用藍新金流)

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

## 金流服務 & FCM推播 & 郵件服務
```
MAIL_DRIVER={driver}
MAIL_HOST={host}
MAIL_PORT={port}
MAIL_USERNAME={user}
MAIL_PASSWORD={password}
MAIL_ENCRYPTION={encryption}
MAIL_FROM_ADDRESS={sender address}
MAIL_FROM_NAME={sender name}


MERCHANT_ID={藍新金流商店代號}
HASH_KEY={藍新金流 Hash Key}
HASH_IV={藍新金流 Hash IV}
NEWEBPAY_API_URL={藍新金流 API網址}

FCM_API_ACCESS_KEY={fcm api key}
```

## 資料表遷移
```
$ php artisan migrate
```

## 隊列監聽
```
$ php artisan queue:work --tries=3 --sleep=5
```