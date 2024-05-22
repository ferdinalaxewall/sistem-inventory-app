# GHP Travel System

## Instalation Guide
- First, clone this project to your local machine `git clone https://github.com/ferdinalaxewall/sistem-inventory-app.git`
- Create environment file based on **.env.example** file `cp .env.example .env`
- Install required packages using command `composer install`
- Generate laravel app key using command `php artisan key:generate`
- Setup database configuration in **.env** file
- Migrate database schema and seed default data using command `php artisan migrate --seed`, if you're already migrated database schema prefer using this command `php artisan migrate:fresh --seed`
- Project setup already finish, to run this project you can use command `php artisan serve`

## Database Configuration (.env)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_inventory
DB_USERNAME=root
DB_PASSWORD=
```
Adjust the default database configuration to the configuration on your local machine by changing the environment value above
