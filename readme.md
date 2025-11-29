# Blamodex Laravel OTP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/blamodex/laravel-otp.svg?style=flat-square)](https://packagist.org/packages/blamodex/laravel-otp)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/blamodex/laravel-otp/ci.yml?label=tests&style=flat-square)](https://github.com/blamodex/laravel-otp/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/blamodex/laravel-otp.svg?style=flat-square)](https://packagist.org/packages/blamodex/laravel-otp)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](https://opensource.org/licenses/MIT)
[![Laravel](https://img.shields.io/badge/Laravel-12-red.svg?style=flat-square)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue.svg?style=flat-square)](https://www.php.net/)

A lightweight Laravel package to add one-time password (OTP) capabilities to any Eloquent model using polymorphic relationships.

---

## Table of Contents

- [Features](#-features)
- [Installation](#-installation)
- [Configuration](#️-configuration)
- [Usage](#-usage)
- [Testing](#-testing)
- [Project Structure](#-project-structure)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🚀 Features

- Attach OTP functionality to any model using a trait
- Polymorphic support for multiple model types
- Configurable alphabet, length, expiry, and hash algorithm
- Secure hashing via `password_hash` and `password_verify`
- Auto-expiration and one-time use enforcement
- Clean architecture: trait, model, service, generator

---

## 📦 Installation

Install the package with Composer:

```bash
composer require blamodex/laravel-otp
```

Publish the config file:

```bash
php artisan vendor:publish --tag=blamodex-otp-config
```

Run the migrations:

```bash
php artisan migrate
```

---

## ⚙️ Configuration

Configuration lives in `config/otp.php`:

```php
return [
    /* PASSWORD ALGORITHM, SEE https://www.php.net/manual/en/function.password-hash.php FOR MORE INFO */
    'algorithm' => PASSWORD_BCRYPT,

    /* PASSWORD ALPHABET */

    //NUMBERS ONLY ALPHABET
    'alphabet' => '0123456789',

    //"WORD SAFE" ALPHABET
    //'alphabet' => '256789BCDFGHJKMNPQRSTVXW',

    //ALPHANUM ALPHABET
    //'alphabet' => '0123456789ABCDEFGHIJKLMNOPQRSTUV';

    /* PASSWORD LENGTH */
    'length' => 6,

    /* PASSWORD EXPIRY */
    'expiry' => 600
];

```

---

## 🧩 Usage

### 1. Implement the interface and use the trait

```php
use Blamodex\Otp\Traits\OneTimePasswordable;
use Blamodex\Otp\Contracts\OneTimePasswordableInterface;

class User extends Model implements OneTimePasswordableInterface
{
    use OneTimePasswordable;
}
```

### 2. Generate an OTP

```php
$user = User::find(1);
$otp = $user->generateOtp(); // returns raw password
```

### 3. Verify an OTP

```php
if ($user->verifyOtp('123456')) {
    // Success
} else {
    // Failure
}
```

---

## 🧪 Testing

This package uses [Orchestra Testbench](https://github.com/orchestral/testbench) and [PHPUnit](https://phpunit.de/).

Run tests:

```bash
composer test
```

Check code style:

```bash
composer lint
```
Check code style and fix:

```bash
composer lint:fix
```

Check coverage (with Xdebug):

```bash
composer test:coverage
```

---

## 📁 Project Structure

```
src/
├── Models/
│   └── OneTimePassword.php
├── Data/
│   └── OtpData.php
├── Services/
│   ├── OtpGenerator.php
│   └── OtpService.php
├── Traits/
│   └── OneTimePasswordable.php
├── Contracts/
│   └── OneTimePasswordableInterface.php
├── config/
│   └── otp.php
└── database/
    └── migrations/
        └── 202x_xx_xx_create_one_time_passwords_table.php

tests/
├── Unit/
├── Fixtures/
└── TestCase.php
```

---

## 🤝 Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

---

## 📝 Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for recent changes.

---

## 📄 License

MIT © [Blamodex](https://github.com/blamodex)

For more information, see the [LICENSE](LICENSE) file.

---

## 🔗 Links

- [Report a Bug](https://github.com/blamodex/laravel-otp/issues)
- [Request a Feature](https://github.com/blamodex/laravel-otp/issues)
- [View Changelog](CHANGELOG.md)
