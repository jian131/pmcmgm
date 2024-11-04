# Pharmacy Management System

A comprehensive pharmacy management system built with Laravel for managing drug stores, inventory, sales, and staff.

## Features

-   **User Management & Authentication**

    -   Role-based access (Admin/Staff)
    -   User authentication with Breeze
    -   Permission management with Spatie

-   **Customer Management**

    -   Customer profiles and history
    -   Loyalty points tracking
    -   Contact information management

-   **Drug/Medicine Management**

    -   Comprehensive drug catalog
    -   Stock tracking
    -   Expiry date monitoring
    -   Category management

-   **Sales Management**

    -   Invoice generation
    -   Receipt management
    -   Multiple payment methods
    -   Sales history

-   **Inventory Management**

    -   Stock level tracking
    -   Purchase order management
    -   Supplier management
    -   Stock alerts

-   **Staff Management**
    -   Employee profiles
    -   Salary management
    -   Attendance tracking
    -   Performance bonuses

## Technology Stack

-   Laravel 10.x
-   MySQL Database
-   PHP 8.1+
-   Breeze Authentication
-   Spatie Permission Management

## Database Structure

The system includes the following key tables:

-   KhachHang (Customers)
-   NhanVien (Employees)
-   Thuoc (Medicines)
-   HoaDon (Invoices)
-   ChiTietHoaDon (Invoice Details)
-   PhieuThu (Receipts)
-   NhaCungCap (Suppliers)
-   PhieuNhap (Purchase Orders)
-   BangLuong (Salary Records)
-   ChiTietLuong (Salary Details)

## Installation

1. Clone the repository

```bash
git clone <repository-url>
```

2. Install dependencies

```bash
composer install
npm install
```

3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

4. Set up database

```bash
php artisan migrate
php artisan db:seed
```

5. Start the application

```bash
php artisan serve
npm run dev
```

## Default Users

-   Admin Account:
    -   Email: admin@example.com
    -   Password: password

## License

This project is licensed under the MIT License.

## Support

For support, please contact [contact information].

```

```
