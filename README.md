<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Инструкция развёртывния проекта


- Создать пустую папку для клонирования проекта
- Прописать в терминале в той же папке `git clone https://github.com/Zuev-Yaroslav/wb-api-bd.git` (убедитесь, что на вашем ПК установлен GIT)
- Создать дубликат файла .env.example и переименовать на .env
- В .env написать пароль {DB_PASSWORD} и базу данных {DB_DATABASE}.

- Запускаем докер:
```` bash
docker-compose up -d
````
- Заходим в wb_api_app контейнер
```` bash
docker exec -it wb_api_app bash
````
```` bash
composer update --no-scripts
php artisan key:generate
php artisan migrate
chmod -R 777 ./
composer update
docker-compose down
docker-compose up -d
````
- Записать в бд данные
```` bash
php artisan pull-from-api
````
- Потом создать компании, аккаунты и просвоить account_id всем таблицам
```` bash
php artisan database:set-account-id-in-tables
````

ТАБЛИЦЫ

- incomes - доходы
- orders - заказы
- sales - продажи
- stocks - склады

Команды
```` bash
php artisan database:get-fresh-entities {income} {page} {token} - получить свежие данные о доходах по последней новой дате
php artisan database:get-fresh-entities {order} {page} {token} - получить свежие данные о заказах по последней новой дате
php artisan database:get-fresh-entities {sale} {page} {token} - получить свежие данные о продажах по последней новой дате
php artisan database:get-fresh-entities {stock} {page} {token} - получить свежие данные о складах по последней новой дате

php artisan store:company {--name=} - создать информацию о компании
php artisan store:api-service {--name=} - создать информацию об апи сервисе
php artisan store:token-type {--name=} {--api_service_id=} - создать информацию о типе токене
php artisan store:api-token {--token=} {--token_type_id=} - создать информацию о токене
php artisan store:account {--name=} {--api_token_id=} {--company_id=} - создать информацию об аккаунте

php artisan database:destroy-entity {income} {id} {token} - удлить информацию о доходе
php artisan database:destroy-entity {order} {id} {token} - удлить информацию о заказе
php artisan database:destroy-entity {sale} {id} {token} - удлить информацию о продаже
php artisan database:destroy-entity {stock} {id} {token} - удлить информацию о складе
````
