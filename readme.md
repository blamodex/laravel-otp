# Blamodex Laravel OTP

A lightweight Laravel package to add one-time password (OTP) capabilities to any Eloquent model using polymorphic relationships.

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

## 📄 License

MIT © [Blamodex](https://github.com/blackmage-codex)
