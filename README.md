# Stock Management API

RESTful API untuk manajemen stok barang berbasis **Laravel**.  
API ini dirancang untuk mengelola produk, transaksi stok, serta autentikasi user.  
Dapat diintegrasikan dengan aplikasi frontend (React, Vue, dll) maupun mobile.

---

## Fitur Utama
- 🔑 Autentikasi user (login & register)
- 📦 CRUD Produk (Create, Read, Update, Delete)
- 🔄 Manajemen Transaksi Stok (penambahan & pengurangan)
- 🗄️ Terhubung dengan MySQL
- 🧪 Dokumentasi & uji API dengan **Postman**

---

## Tech Stack
- [Laravel 10](https://laravel.com/)
- [MySQL](https://www.mysql.com/)
- [Composer](https://getcomposer.org/)
- [Postman](https://www.postman.com/)

---

## Cara Menjalankan Project

```bash
# 1. Clone Repository
git clone https://github.com/Geraldobanjarnahor/stock-management-api.git
cd stock-management-api

# 2. Install Dependency
composer install

# 3. Copy & Konfigurasi Environment
cp .env.example .env
# lalu sesuaikan konfigurasi database di file .env

# 4. Generate Key & Migrasi Database
php artisan key:generate
php artisan migrate

# 5. Jalankan Server
php artisan serve
