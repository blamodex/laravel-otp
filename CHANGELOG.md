# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2025-11-29

### Added
- Initial release
- OneTimePassword model with polymorphic relationships
- OneTimePasswordable trait for any Eloquent model
- OtpService for OTP generation, verification, and management
- OtpGenerator with configurable alphabet, length, and hashing
- OtpValidator for validation logic
- Configurable OTP expiration times
- One-time use enforcement
- Secure password hashing (bcrypt/argon2)
- Events: OneTimePasswordCreated, OneTimePasswordUsed
- Complete test coverage (17 tests, 24 assertions)
- Migrations and factories
- Laravel service provider with auto-discovery

[Unreleased]: https://github.com/blamodex/laravel-otp/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/blamodex/laravel-otp/releases/tag/v1.0.0
