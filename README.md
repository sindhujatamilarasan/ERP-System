**Mini ERP System - README**
Introduction
This is a basic ERP System built using Laravel, focusing on Inventory Management and Sales Order processing, designed for a candidate assessment task.

**Features**
Authentication with Laravel Breeze

Role-based access control (Admin, Salesperson)

**Product CRUD with inventory management**

Sales Order creation with automatic stock reduction

Dashboard with summary statistics

PDF invoice generation using dompdf

RESTful API endpoints with Sanctum authentication

**Requirements**
PHP >= 8.2

Composer

Laravel 11+

MySQL

**Setup Instructions**

1. Clone the Repository
git clone https://github.com/your-username/mini-erp.git
cd mini-erp
2. Install Dependencies
composer install
npm install && npm run build
3. Environment Setup
cp .env.example .env
php artisan key:generate
4. Database Configuration
Update your .env with your DB credentials:
DB_DATABASE=erp_db  
DB_USERNAME=root
DB_PASSWORD=
Then run:
php artisan migrate --seed
6. Start the Development Server
php artisan serve
Seeded Users
**Admin**
**Email**: admin@example.com
**Password**: 123456

**Salesperson**
**Email**: salesperson@example.com
**Password**: 123456

**API Endpoints**
All API routes are protected with Sanctum authentication.
Method	Endpoint	Description
**GET**	/api/products	List all products
**POST**	/api/sales-orders	Create a new sales order
**GET**	/api/sales-orders/{id}	Retrieve specific sales order

**To use the APIs**:
Authenticate using Sanctum to obtain a token.
Send requests with Authorization: Bearer {token} header.
PDF Output
After creating a sales order, you can download the invoice as a PDF.
