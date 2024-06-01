# Stockflow - Sistem Manajemen Inventori
Stockflow adalah sebuauh aplikasi sistem manajamen inventori berbasis website yang ditargetkan untuk para mitra/pelaku bisnis UMKM

## Application Requirement
- PHP versi 8.2 atau diatasnya. [Link Download PHP 8.2](https://windows.php.net/download#php-8.2)
- Composer. [Link Download Composer](https://getcomposer.org/Composer-Setup.exe)
- Database MySQL. [Link Download MySQL Server](https://dev.mysql.com/downloads/mysql/)
- Akun Google SMTP/Mailtrap SMTP
    - [Link Tutorial Google SMTP](https://divisidev.com/post/laravel-gmail-smtp)
    - [Link Tutorial Mailtrap SMTP](https://www.giuseppemaccario.com/how-to-send-emails-in-laravel-using-mailtrap/)


## Instalasi Aplikasi Stockflow
- Silahkan ekstrak file project .zip atau clone project menggunakan perintah `git clone https://github.com/ferdinalaxewall/sistem-inventory-app.git`
- Buat sebuah envinronment variable file dengan meng-copy .env.example file `cp .env.example .env`
- Install package-package yang dibutuhkan menggunakan perintah composer `composer install`
- Generate Laravel Application Key menggunakan perintah `php artisan key:generate`
- Silahkan atur SMTP configuration di `.env` file (Karena pada aplikasi ini terdapat verifikasi akun menggunakan Email jadi SMTP perlu dikonfigurasi terlebih dahulu)
- Silahkan atur database configuration di `.env` file
- Setelah database terkonfigurasi dengan benar, lakukan migrasi database dan default seeder yang sudah disediakan dengan perintah `php artisan key:generate`
- Proses setup konfigurasi aplikasi sudah selesai, silahkan jalankan aplikasi menggunakan perintah `php artisan serve`

## Konfigurasi Database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stockflow
DB_USERNAME=root
DB_PASSWORD=
```

- DB_CONNECTION = mysql
- DB_HOST = 127.0.0.1/localhost atau sesuaikan dengan host database anda
- DB_PORT = 3306 atau sesuaikan dengan port database anda
- DB_DATABASE = stockflow atau sesuaikan dengan nama database anda
- DB_USERNAME = root atau sesuaikan dengan username database anda
- DB_DATABASE = "" atau sesuaikan dengan password database anda


## Konfigurasi SMTP
Silahkan ubah konfigurasi SMPT pada file `.env`, ada beberapa Channel SMTP yang disarankan:
1. Google SMTP
    ```
    # SMTP menggunakan GMAIL
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME="your-email@gmail.com"
    MAIL_PASSWORD="your-google-application-key"
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="your-email@gmail.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

    - Silahkan isi MAIL_USERNAME, MAIL_PASSWORD, dan MAIL_FROM_ADDRESS sesuai dengan akun google anda
    - Untuk melakukan konfigurasi SMTP anda perlu menggunakan "Google Sandi Aplikasi", bisa lihat artikel ini untuk generate sandi aplikasi nya. [Lihat Tutorial](https://divisidev.com/post/laravel-gmail-smtp)

2. [Mailtrap](https://mailtrap.io) SMTP
    ```
    # SMTP menggunakan GMAIL
    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME="your-mailtrap-username"
    MAIL_PASSWORD="your-mailtrap-password"
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="your-email@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

    - Silahkan isi MAIL_USERNAME, MAIL_PASSWORD, dan MAIL_FROM_ADDRESS sesuai dengan akun [Mailtrap](https://mailtrap.io) anda
    - Untuk melakukan konfigurasi SMTP anda perlu menggunakan "Google Sandi Aplikasi", bisa lihat artikel ini untuk generate sandi aplikasi nya. [Lihat Tutorial](https://www.giuseppemaccario.com/how-to-send-emails-in-laravel-using-mailtrap/)


## Administrator
Untuk default akun admin bisa menggunakan data:
- Email: admin@stockflow.fun
- Password: password

