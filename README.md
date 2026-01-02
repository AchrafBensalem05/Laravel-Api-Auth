# Laravel API Authentication with JWT & Roles

A complete Laravel API authentication system with JWT tokens and role-based access control. This project demonstrates clean code architecture with Services, Requests, Resources, and custom middleware.

## 🚀 Features

- **JWT Authentication** using `tymon/jwt-auth`
- **User Registration & Login** with automatic token generation
- **Password Reset via Email** with secure token validation
- **Role-based Access Control** (User, Admin, Superadmin)
- **Custom Middleware** for role protection
- **Clean Code Architecture** with Services, Requests, and Resources
- **Auto-login after registration**
- **Comprehensive API testing** with `.http` files

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Auth/
│   │       └── AuthController.php        # Authentication endpoints
│   ├── Middleware/
│   │   └── RoleMiddleware.php             # Role-based access control
│   ├── Requests/
│   │   └── Auth/
│   │       ├── LoginRequest.php           # Login validation
│   │       └── RegisterRequest.php        # Registration validation
│   └── Resources/
│       └── UserResource.php               # User data formatting
├── Models/
│   └── User.php                          # User model with JWT interface
└── Services/
    └── AuthService.php                   # Business logic layer
```

## 🛠️ Installation & Setup

### Prerequisites
- PHP 8.2+
- Composer
- MySQL/PostgreSQL/SQLite

### Installation Steps

1. **Clone the repository**
```bash
git clone https://github.com/AchrafBensalem05/Laravel-Api-Auth.git
cd Laravel-Api-Auth
```

2. **Install dependencies**
```bash
composer install
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

4. **Configure database**
Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_auth
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run migrations**
```bash
php artisan migrate
```

6. **Configure email settings (optional)**
For password reset emails, update your `.env` file:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-email-password
MAIL_FROM_ADDRESS="noreply@yourapp.com"
MAIL_FROM_NAME="Your App Name"
```

7. **Start the server**
```bash
php artisan serve
```

The API will be available at: `http://localhost:8000/api`

## 📚 API Endpoints

### Authentication Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/auth/register` | Register new user & auto-login | No |
| POST | `/api/auth/login` | Login user | No |
| POST | `/api/auth/logout` | Logout user | Yes |
| POST | `/api/auth/forgot-password` | Request password reset email | No |
| POST | `/api/auth/reset-password` | Reset password with token | No |

### Protected Endpoints

| Method | Endpoint | Description | Required Role |
|--------|----------|-------------|---------------|
| GET | `/api/admin/dashboard` | Admin dashboard | Admin or Superadmin |
| GET | `/api/superadmin/dashboard` | Superadmin dashboard | Superadmin only |

## 🔐 User Roles

- **User** (default): Basic authenticated user
- **Admin**: Can access admin dashboard
- **Superadmin**: Can access both admin and superadmin dashboards

## 📝 API Testing

Use the provided `tests/api.http` file with VS Code REST Client extension:

### Register a new user
```http
POST http://localhost:8000/api/auth/register
Content-Type: application/json

{
    "name": "Test User",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

### Register an admin user
```http
POST http://localhost:8000/api/auth/register
Content-Type: application/json

{
    "name": "Admin User",
    "email": "admin@example.com",
    "password": "password",
    "password_confirmation": "password",
    "role": "admin"
}
```

### Login
```http
POST http://localhost:8000/api/auth/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

### Request Password Reset
```http
POST http://localhost:8000/api/auth/forgot-password
Content-Type: application/json

{
    "email": "user@example.com"
}
```

### Reset Password
```http
POST http://localhost:8000/api/auth/reset-password
Content-Type: application/json

{
    "email": "user@example.com",
    "token": "reset_token_from_email",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

### Access protected endpoints
```http
GET http://localhost:8000/api/admin/dashboard
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json
```

## 🏗️ Architecture Overview

### Clean Code Principles

1. **Service Layer**: Business logic separated in `AuthService`
2. **Form Requests**: Input validation in dedicated Request classes
3. **Resources**: Consistent API response formatting
4. **Middleware**: Role-based access control
5. **Single Responsibility**: Each class has one clear purpose

### JWT Token Structure

The JWT token contains:
- `user_id`: User's database ID
- `name`: User's name
- Standard JWT claims (iat, exp, etc.)

### Password Reset Flow

1. **Request Reset**: User provides email to `/api/auth/forgot-password`
2. **Email Sent**: System sends reset token via email (if email exists)
3. **Reset Password**: User uses token from email with new password at `/api/auth/reset-password`
4. **Token Expires**: Reset tokens expire after 24 hours

**Security Features:**
- Tokens are hashed before storage
- Generic response messages (prevent email enumeration)
- 24-hour token expiration
- Single-use tokens (deleted after use)

### Response Examples

**Successful Registration:**
```json
{
    "user": {
        "id": 1,
        "name": "Test User",
        "email": "user@example.com",
        "role": "user"
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "bearer",
    "expires_in": 3600
}
```

**Successful Login:**
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "bearer",
    "expires_in": 3600
}
```

## 🔧 Configuration

### JWT Configuration
The JWT configuration is located in `config/jwt.php`. Key settings:
- **TTL**: Token expiration time (default: 60 minutes)
- **Algorithm**: HMAC SHA256
- **Custom Claims**: user_id and name included in token

### Auth Configuration
Updated `config/auth.php` to use JWT as default API guard:
```php
'defaults' => [
    'guard' => 'api',
],

'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

## 🧪 Testing

The project includes comprehensive API tests in `tests/api.http`. To test:

1. Start the server: `php artisan serve`
2. Open `tests/api.http` in VS Code
3. Install REST Client extension
4. Run the requests sequentially
5. Copy tokens from login responses for protected endpoints

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 Author

**Achraf Bensalem**
- GitHub: [@AchrafBensalem05](https://github.com/AchrafBensalem05)
- Repository: [Laravel-Api-Auth](https://github.com/AchrafBensalem05/Laravel-Api-Auth)

---

⭐ If you found this project helpful, please give it a star!

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
