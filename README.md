# 🍽️ FoodShare - Food Waste Reduction Platform

<p align="center">
    <img src="public/logo.svg" alt="FoodShare Logo" width="200">
</p>

<p align="center">
    <strong>A Laravel-based platform connecting food donors with those in need to reduce food waste</strong>
</p>

<p align="center">
    <a href="https://foodshare-mu.vercel.app/" target="_blank">🌐 Live Demo</a> •
    <a href="#features">✨ Features</a> •
    <a href="#installation">🚀 Installation</a> •
    <a href="#tech-stack">🛠️ Tech Stack</a>
</p>

---

## 📖 About

**FoodShare** is a web application designed to tackle food waste by creating a bridge between food donors (restaurants, grocery stores, individuals) and recipients (food banks, shelters, individuals in need). The platform enables users to post available food donations and allows others to request them, fostering community collaboration while reducing environmental impact.

### 🎯 Mission
To reduce food waste and fight hunger in communities by facilitating easy food sharing between donors and recipients.

## ✨ Features

### 🔐 User Management
- **User Registration & Authentication** - Secure account creation and login
- **Role-based Access** - Different permissions for donors and recipients
- **Profile Management** - Update personal information and preferences

### 🍔 Donation Management
- **Create Donations** - Post available food with details like category, quantity, and expiration
- **Browse Donations** - Search and filter available food donations
- **Donation Status Tracking** - Track the status of your donations (available, requested, completed)
- **Categories** - Organize food by type (vegetables, fruits, prepared meals, etc.)

### 📝 Request System
- **Request Food** - Submit requests for specific donations with messages
- **Request Management** - View and manage your food requests
- **Status Updates** - Track request status (pending, approved, declined)
- **Communication** - Message system between donors and recipients

### 📊 Dashboard
- **Donor Dashboard** - Manage your donations and incoming requests
- **Recipient Dashboard** - Track your requests and browse available food
- **Analytics** - View impact statistics and donation history

### 🔒 Security & Compliance
- **SSL Encryption** - Secure data transmission
- **Input Validation** - Protection against malicious inputs
- **Authentication** - Laravel Breeze for secure user management

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12.x (PHP 8.2+)
- **Database**: PostgreSQL (Neon Database)
- **Authentication**: Laravel Breeze
- **Validation**: Laravel Form Requests
- **Testing**: PHPUnit with Pest

### Frontend
- **CSS Framework**: Tailwind CSS
- **Build Tool**: Vite
- **JavaScript**: Vanilla JS with modern ES6+ features
- **Templating**: Blade (Laravel's templating engine)

### Infrastructure & Deployment
- **Hosting**: Vercel (Production)
- **Database**: Neon PostgreSQL (Cloud)
- **Local Development**: XAMPP
- **Version Control**: Git

### Additional Tools
- **Package Manager**: Composer (PHP), NPM (Node.js)
- **Code Quality**: Laravel Pint (PHP CS Fixer)
- **Environment Management**: Laravel .env configuration

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- PostgreSQL database (or use provided Neon database)

### Local Development Setup

1. **Clone the repository**
```bash
git clone https://github.com/DilukM/food-waste-platform.git
cd food-waste-platform
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node.js dependencies**
```bash
npm install
```

4. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure Database**
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=pgsql
DB_HOST=your-database-host
DB_PORT=5432
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

6. **Run Migrations**
```bash
php artisan migrate
```

7. **Seed Database (Optional)**
```bash
php artisan db:seed
```

8. **Build Assets**
```bash
npm run build
```

9. **Start Development Server**
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

### Production Deployment (Vercel)

1. **Configure vercel.json**
The project includes a pre-configured `vercel.json` for deployment.

2. **Deploy to Vercel**
```bash
vercel --prod
```

3. **Environment Variables**
Set the following environment variables in Vercel dashboard:
- Database credentials
- APP_KEY
- APP_URL
- Any other required environment variables

## 📁 Project Structure

```
food-waste-platform/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   ├── Providers/           # Service providers
│   └── ...
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── public/                 # Public assets
├── resources/
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript files
│   └── views/             # Blade templates
├── routes/                # Application routes
├── config/                # Configuration files
├── storage/               # File storage
├── tests/                 # Application tests
├── .env.example          # Environment variables template
├── composer.json         # PHP dependencies
├── package.json          # Node.js dependencies
├── vercel.json           # Vercel deployment config
└── README.md             # This file
```

## 🎮 Usage

### For Donors
1. **Register/Login** to your account
2. **Create a Donation** by providing food details
3. **Manage Requests** from recipients
4. **Update Status** when food is collected

### For Recipients
1. **Register/Login** to your account
2. **Browse Available Food** using filters
3. **Submit Requests** for needed items
4. **Track Request Status** in your dashboard

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Use meaningful commit messages

## 🧪 Testing

Run the test suite:
```bash
./vendor/bin/pest
```

Or with PHPUnit:
```bash
./vendor/bin/phpunit
```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👥 Team

- **Developer**: [DilukM](https://github.com/DilukM)

## 🙏 Acknowledgments

- Laravel community for the amazing framework
- Neon Database for reliable PostgreSQL hosting
- Vercel for seamless deployment
- Tailwind CSS for beautiful styling
- All contributors and users who help reduce food waste

## 📞 Support

If you encounter any issues or have questions:
- Create an [Issue](https://github.com/DilukM/food-waste-platform/issues)
- Contact: dilukedu@gmail.com

---

<p align="center">
    <strong>Together, we can reduce food waste and build stronger communities! 🌱</strong>
</p>
