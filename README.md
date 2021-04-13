## 1/ Environment
- php: >=8.0
- docker

## 2/ Run docker
```
docker-compose up -d
```

## 3/ Run migrate
```
docker-compose exec contacts-backend php artisan migrate
```

## 4/ seeder
```
docker-compose exec contacts-backend php artisan db:seed
```

## 5/ Run schedule
```
docker-compose exec contacts-backend crontab -e
```
Thêm dòng dưới và lưu
```
* * * * * cd /var/www/html/ && '/usr/local/bin/php' artisan contact-update:subscriberCount > /var/www/html/storage/logs/schedule.log
```
