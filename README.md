# 🥬 FreshMart - Fresh Produce E-Commerce Platform

<div align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Filament-F59E0B?style=for-the-badge&logo=laravel&logoColor=white" alt="Filament">
</div>

<div align="center">
  <h3>🌱 Modern Fresh Produce Marketplace with Multi-Role Management</h3>
  <p>A comprehensive e-commerce platform for fresh fruits and vegetables with advanced admin panel, inventory management, and seamless customer experience.</p>
</div>

## ✨ Features

### 🛒 **Customer Features**

-   **Product Browsing**: Browse fresh produce by categories with high-quality images
-   **Smart Cart System**: Add/remove items with real-time quantity updates
-   **Secure Checkout**: Multiple payment methods (Bank Transfer, Cash, E-Wallet)
-   **Order Tracking**: Real-time order status updates and notifications
-   **Responsive Design**: Optimized for mobile, tablet, and desktop

### 👨‍💼 **Admin Features**

-   **Dashboard Analytics**: Comprehensive sales and inventory insights
-   **Product Management**: CRUD operations with image upload and categorization
-   **Order Management**: Process orders, update status, and manage payments
-   **User Management**: Manage customers, merchants, and admin accounts
-   **Payment Verification**: Review and approve payment proofs
-   **Inventory Tracking**: Real-time stock management and low-stock alerts

### 🏪 **Merchant Features**

-   **Product Listing**: Add and manage product inventory
-   **Sales Analytics**: Track sales performance and revenue
-   **Order Processing**: Manage incoming orders and fulfillment
-   **Customer Communication**: Order notifications and updates

## 🚀 Tech Stack

### **Backend**

-   **Laravel 11** - Modern PHP framework with elegant syntax
-   **MySQL** - Reliable relational database management
-   **Filament 3** - Beautiful admin panel with rich components
-   **Laravel Notifications** - Real-time order and payment updates

### **Frontend**

-   **Blade Templates** - Laravel's powerful templating engine
-   **Tailwind CSS** - Utility-first CSS framework for custom designs
-   **Alpine.js** - Lightweight JavaScript framework for interactivity
-   **Vite** - Fast build tool for modern web projects

### **Additional Features**

-   **Multi-Authentication** - Role-based access control (Admin, Merchant, Customer)
-   **File Upload System** - Product images and payment proof handling
-   **Database Seeding** - Pre-populated test data for development
-   **Responsive Design** - Mobile-first approach with modern UI/UX

## 📁 Project Structure

```
FreshMart/
├── app/
│   ├── Filament/           # Admin panel resources
│   ├── Http/Controllers/   # Application controllers
│   ├── Models/             # Eloquent models
│   └── Notifications/      # System notifications
├── database/
│   ├── migrations/         # Database schema
│   └── seeders/           # Test data
├── resources/
│   ├── css/               # Styling files
│   ├── js/                # JavaScript files
│   └── views/             # Blade templates
└── public/                # Static assets
```

## 🔧 Installation & Setup

### **Prerequisites**

-   PHP 8.2 or higher
-   Composer
-   Node.js & NPM
-   MySQL 8.0
-   Web server (Apache/Nginx) or Laragon/XAMPP

### **Step 1: Clone Repository**

```bash
git clone <repository-url>
cd FreshMart
```

### **Step 2: Install Dependencies**

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### **Step 3: Environment Configuration**

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### **Step 4: Database Setup**

1. Create MySQL database named `freshmart`
2. Update `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=freshmart
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### **Step 5: Run Migrations & Seeders**

```bash
# Run database migrations
php artisan migrate

# Seed database with test data
php artisan db:seed
```

### **Step 6: Storage Setup**

```bash
# Create symbolic link for file storage
php artisan storage:link
```

### **Step 7: Build Assets**

```bash
# Build CSS and JavaScript assets
npm run build

# Or for development with hot reload
npm run dev
```

### **Step 8: Start Development Server**

```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 👥 Default User Accounts

The system comes with pre-configured test accounts for different roles:

| Role         | Email                  | Password | Access Level                        |
| ------------ | ---------------------- | -------- | ----------------------------------- |
| **Admin**    | admin@freshmart.com    | password | Full system access, user management |
| **Merchant** | merchant@freshmart.com | password | Product & inventory management      |
| **Customer** | customer@freshmart.com | password | Shopping and order management       |

## 🎯 Usage Guide

### **For Customers:**

1. **Browse Products**: Visit the homepage to see available fresh produce
2. **Add to Cart**: Click "Add to Cart" on desired products
3. **Checkout**: Review cart and proceed to secure checkout
4. **Payment**: Upload payment proof and track order status
5. **Receive Orders**: Get notifications about order updates

### **For Admin:**

1. **Access Admin Panel**: Visit `/admin` and login with admin credentials
2. **Manage Products**: Add/edit/delete products with images and categories
3. **Process Orders**: Review orders, verify payments, update status
4. **Monitor Analytics**: View sales dashboard and inventory reports
5. **User Management**: Manage customer and merchant accounts

### **For Merchants:**

1. **Product Management**: Add and update product listings
2. **Inventory Control**: Track stock levels and manage availability
3. **Order Processing**: Fulfill customer orders and update status
4. **Sales Analytics**: Monitor performance and revenue metrics

## 📱 Screenshots

### Customer Interface

-   **Homepage**: Clean product grid with category filtering
-   **Product Details**: High-quality images with detailed descriptions
-   **Shopping Cart**: Intuitive quantity controls and price calculations
-   **Checkout**: Streamlined payment process with multiple options

### Admin Panel

-   **Dashboard**: Comprehensive analytics and quick stats
-   **Product Management**: Rich form controls with image upload
-   **Order Management**: Detailed order tracking and status updates
-   **User Management**: Role-based access control interface

## 🔐 Security Features

-   **Authentication**: Secure login system with password hashing
-   **Authorization**: Role-based access control (RBAC)
-   **CSRF Protection**: Cross-site request forgery prevention
-   **File Upload Security**: Validated and sanitized file handling
-   **Database Security**: Prepared statements and SQL injection prevention

## 🌟 Key Benefits

-   **Scalable Architecture**: Built on Laravel's robust foundation
-   **Modern UI/UX**: Responsive design with Tailwind CSS
-   **Easy Maintenance**: Clean code structure and documentation
-   **Extensible**: Modular design for easy feature additions
-   **Production Ready**: Optimized for performance and security

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
