# 🚀 Laravel 11 Boilerplate (Enhanced Edition) by Refkinscallv

A modern Laravel 11 boilerplate with extended utilities and command tools for faster and cleaner backend development.
Includes built-in JWT, Mailer, Validator, Service base classes, and artisan generators.

---

## 🧩 Features

### 🔧 Core Enhancements

* **Laravel 11 base** with extended architecture.
* **Additional libraries**:

  * [`firebase/php-jwt`](https://github.com/firebase/php-jwt) – For secure JWT handling.
  * [`phpmailer/phpmailer`](https://github.com/PHPMailer/PHPMailer) – For direct email sending via SMTP.

---

## 🎨 Frontend Packages

### 📦 CSS & UI

| Library                                                                 | CDN                      | Description                                            |
| ----------------------------------------------------------------------- | ------------------------ | ------------------------------------------------------ |
| [Tailwind CSS](https://tailwindcss.com)                                 | `@tailwindcss/browser@4` | Utility-first CSS framework                            |
| [DaisyUI](https://daisyui.com)                                          | `@5`                     | Prebuilt UI components for Tailwind                    |
| [Remix Icon](https://remixicon.com)                                     | `@4.5.0`                 | Lightweight and modern icon pack                       |
| [Tom Select](https://tom-select.js.org)                                 | `@2.4.3`                 | Dropdown and autocomplete control                      |
| [DataTables](https://datatables.net)                                    | `dt-2.3.4`               | Interactive tables with search, export, and pagination |
| [Google Fonts – Quicksand](https://fonts.google.com/specimen/Quicksand) |                          | Main application font                                  |

### ⚙️ JavaScript & Tools

| Library                                                          | CDN                      | Description                          |
| ---------------------------------------------------------------- | ------------------------ | ------------------------------------ |
| [jQuery](https://jquery.com)                                     | `3.7.1`                  | DOM manipulation & event handling    |
| [Axios](https://axios-http.com)                                  | Latest CDN               | HTTP client for API calls            |
| [Tom Select JS](https://tom-select.js.org)                       | `@2.4.3`                 | Select dropdown controller           |
| [PDFMake](https://pdfmake.github.io/docs/)                       | `0.2.7`                  | Client-side PDF generation           |
| [DataTables JS Bundle](https://datatables.net/download/)         | Matched with CSS version | Export and responsive features       |

### 🧠 Internal JS Modules

| File               | Description                                                         |
| ------------------ | ------------------------------------------------------------------- |
| `alert.js`         | Custom SweetAlert-like modal using `<dialog>`                       |
| `axios.js`         | Axios wrapper with interceptor for unified error handling           |
| `common.js`        | Global helpers (form handling, formatting, tables, selects, etc.)   |
| `prompt.js`        | Custom prompt modal for user input                                  |
| `state.js`         | Lightweight reactive state handler                                  |
| `common.js (main)` | Entry point for UI initialization, flash system, theme toggle, etc. |

### 🖼️ Style & Behavior

* Default font: **Quicksand**
* Minimalist custom scrollbar
* Dark/light theme toggle with `localStorage.themeMode`
* Right-click disabled and history caching prevention
* Loading overlay and image preview system

---

## 🧠 Custom Commands

### 🛠 ServiceMaker

Generate a new service file under `app/Services`.

```bash
php artisan make:service UserService
```

### 🧾 ValidatorMaker

Generate a new validator file under `app/Http/Validators`.

```bash
php artisan make:validator UserValidator
```

---

## 🧱 Base Architecture

### 1. **Base Controller**

Path: `app/Http/Controllers/Controller.php`
Provides two helper methods:

* `json()` → unified JSON API response.
* `view()` → render view with optional headers and status code.

---

### 2. **Middleware: Cache**

Path: `app/Http/Middleware/Cache.php`
Automatically disables client-side caching for every request:

```php
Cache-Control: no-cache, no-store, must-revalidate
```

---

### 3. **Base Validator**

Path: `app/Http/Validators/Base.php`
Simplifies request validation and alias mapping with a consistent structure:

```php
[
  'status' => true|false,
  'data'   => [...],
  'error'  => [...]
]
```

---

### 4. **Base Service**

Path: `app/Services/Base.php`
Provides a unified layer for:

* Safe database transactions (`handler()`)
* File management (upload, delete, multiple uploads)
* Database error parsing
* Unified JSON response builder

Includes helpers like:

* `uploadSingleFile()`
* `uploadMultipleFiles()`
* `uploadUrlFile()`
* `deleteFile()` / `deleteMultipleFiles()`
* `upsertHasOne()` for relational updates

---

### 5. **Flash Utils**

Path: `app/Utils/Flash.php`
Lightweight session flash helper:

```php
flash('success', 'User created!');
flash_get('success'); // => "User created!"
flash_clear(); // clear all flash data
```

---

### 6. **JWT Utils**

Path: `app/Utils/JWT.php`
Wrapper for `firebase/php-jwt` with `.env` auto-configuration.

Methods:

* `JWT::generate($payload, $ttl = 0)`
* `JWT::verify($token)`
* `JWT::decode($token)`
* `JWT::encode($data)`

Supported `.env` keys:

```env
JWT_ALGO=HS256
JWT_SECRET=your-secret-key
JWT_TTL=3600
```

---

### 7. **Mailer Utils**

Path: `app/Utils/Mailer.php`
Wrapper for `PHPMailer` with Laravel-style configuration.

Config file: `config/phpmailer.php`

```php
return [
  'debug' => env('MAILER_DEBUG', false),
  'credentials' => [
    'host' => env('MAILER_HOST', ''),
    'auth' => env('MAILER_AUTH', true),
    'user' => env('MAILER_USERNAME', ''),
    'pass' => env('MAILER_PASSWORD', ''),
    'secure' => env('MAILER_SECURE', true),
  ],
];
```

Supported `.env` keys:

```env
MAILER_DEBUG=false
MAILER_HOST=
MAILER_AUTH=true
MAILER_NAME=
MAILER_USERNAME=
MAILER_PASSWORD=
MAILER_SECURE=true
```

Usage:

```php
use App\Utils\Mailer;

Mailer::send([
  'to' => 'user@example.com',
  'subject' => 'Welcome!',
  'body' => '<b>Hello User</b>',
]);
```

---

### 8. **App Service Provider**

Path: `app/Providers/AppServiceProvider.php`
Automatically initializes `JWT` and `Mailer` on boot:

```php
JWT::init();
Mailer::init(config('phpmailer'));
```

---

### 9. **Custom Middleware Registration**

`bootstrap/app.php` registers:

* Web & API middleware groups
* Global Cache middleware
* Custom command registrations for `ServiceMaker` and `ValidatorMaker`

---

## ⚙️ Installation

```bash
git clone https://github.com/yourname/laravel-11-boilerplate.git
cd laravel-11-boilerplate
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

Then serve your app:

```bash
php artisan serve
```

---

## 🧪 Requirements

* PHP **>= 8.2**
* Composer **>= 2.x**
* Laravel **11.x**
* MySQL or SQLite (for default migrations)
* OpenSSL (for JWT)

---

## 🧤 Example Usage

### ✅ API Controller Example

```php
namespace App\Http\Controllers;

use App\Services\UserService;

class UserController extends Controller
{
    public function index(UserService $service)
    {
        $response = $service->getAllUsers();
        return $this->json($response);
    }
}
```

### ✅ Service Example

```php
namespace App\Services;

class UserService extends Base
{
    public function getAllUsers()
    {
        return $this->handler(function () {
            $users = \App\Models\User::all();
            return $this->json(true, 200, 'Success', $users);
        });
    }
}
```

---

## 🧰 License

This project is open-sourced software licensed under the **MIT license**.
