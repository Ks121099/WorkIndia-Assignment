## WorkIndia Assignment
### Requirements
1. composer
2. php >7.2
3. Mysql

### installation
 ```bash
 composer install 
 cp .env.example .env
 php artisan key:genrate 
 ```
 Update your database 
 ```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Yourdatabase
DB_USERNAME=username
DB_PASSWORD=password    
```
Run the migrations and run the app
```bash
php artisan migrate
php artisan serve
```
