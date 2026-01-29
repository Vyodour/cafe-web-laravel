<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<p align="center">
    <!-- Laravel Version -->
    <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Version">
    <!-- PHP Version -->
    <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
    <!-- Testing Status -->
    <img src="https://img.shields.io/badge/testing-passed-success?style=for-the-badge&logo=github-actions&logoColor=white" alt="Testing Status">
    <!-- License -->
    <img src="https://img.shields.io/badge/license-MIT-blue?style=for-the-badge" alt="License">
</p>

# ☕ Web Kafe - Online Cafe Ordering System

**Web Kafe** is a web-based application built using the **Laravel** framework to streamline cafe menu management and ordering. The application serves two main roles: **Admin** for data management (products, categories, cashier) and **Student/Visitor** for placing orders.

This application aims to digitize the food and beverage ordering process in school environments or cafes, complete with digital payment integration.

---

## 🚀 Key Features

### 👑 Admin (Administrator) & Cashier
- **Dashboard**: View sales statistics and order summaries.
- **Product Management**: Add, edit, and delete food/beverage items with images.
- **Category Management**: Group products by category (e.g., Heavy Meals, Drinks, Snacks).
- **Table Management**: Manage table numbers for *dine-in* orders.
- **Order Management**: View incoming orders, process, and complete them.
- **Transaction Reports**: View sales transaction history.
- **Cafe Settings**: Manage cafe profile.

### 👤 Visitor (Student/User)
- **Menu Catalog**: Browse available menus with an attractive interface.
- **Search Cafe**: Choose a cafe (if multi-tenant) or menu category.
- **Shopping Cart**: Add items to the cart before checkout.
- **Checkout & Payment**: Place orders and pay (integrated with Payment Gateways like Midtrans).
- **Order History**: Track order status (Pending, Processing, Completed).
- **Notifications**: Get updates on order status.

---

## 🛠️ Technology Stack

- **Backend**: Laravel 11 / 12 (PHP Framework)
- **Frontend**: Blade Templates, Tailwind CSS (Modern UI)
- **Database**: MySQL
- **Payment Gateway**: Midtrans
- **Authentication**: Laravel Fortify

---

## 💻 Installation Guide (Beginner Friendly)

Follow these steps to run the project on your local machine. Ensure you have **XAMPP** (for PHP & MySQL), **Composer**, and **Node.js** installed.

### 1. Clone Project
Download or clone this project to your computer. Open your terminal (CMD/Git Bash) and run:
```bash
git clone https://github.com/your-username/web-kafe.git
cd web-kafe
```

### 2. Install PHP Dependencies (Laravel)
Install all required PHP libraries using Composer:
```bash
composer install
```

### 3. Install Frontend Dependencies (CSS/JS)
Install libraries for the frontend (Tailwind, etc.) and compile assets:
```bash
npm install
npm run build
```

### 4. Environment Configuration (.env)
Copy the example configuration file to create a new `.env` file:
```bash
cp .env.example .env
```
Open the `.env` file with a text editor (Notepad/VS Code), find the **Database** section, and adjust it (usually looks like this for default XAMPP):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_kafe  <-- Make sure you create a database with this name in phpMyAdmin
DB_USERNAME=root
DB_PASSWORD=
```
*Don't forget to set `MIDTRANS_SERVER_KEY` and `MIDTRANS_CLIENT_KEY` if you want the payment feature to work.*

### 5. Generate Key & Setup Database
Run the following commands to generate the application security key and create tables in the database:
```bash
php artisan key:generate
php artisan migrate --seed
```
*(The `--seed` option will populate initial/dummy data like the default Admin account)*

### 6. Run Application
Now the project is ready to run! Type this command in your terminal:
```bash
php artisan serve
```
Open your browser (Chrome/Edge) and access the URL shown, typically:
**http://127.0.0.1:8000**

---

## 🧪 Testing

This project has undergone testing to ensure features work correctly.
To run manual tests (Unit/Feature tests):
```bash
php artisan test
```

---

## 📄 License

Web Kafe is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
