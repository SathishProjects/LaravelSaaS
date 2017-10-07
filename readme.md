#Commands

1. composer update

2. sudo chmod -R 777 storage/*

3. sudo chown -R root:sathish storage/*

4.  cp .env.example .env

5. php artisan key:generate

6. DB_CONNECTION=mysql -> DB_CONNECTION=main

6. php artisan migrate:fresh