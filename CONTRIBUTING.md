# Contributing to Laravel OTP

Thank you for considering contributing to Blamodex Laravel OTP!

## How to Contribute

### Reporting Issues

- Check existing issues before creating a new one
- Provide clear descriptions with steps to reproduce
- Include Laravel version, PHP version, and package version

### Pull Requests

1. **Fork the repository**
2. **Create a feature branch** (`git checkout -b feature/your-feature`)
3. **Follow PSR-12 coding standards**
4. **Write or update tests** for your changes
5. **Ensure all tests pass** (`composer test`)
6. **Run linting** (`composer lint`)
7. **Run static analysis** (`composer analyze`)
8. **Commit your changes** with clear messages
9. **Push to your fork** (`git push origin feature/your-feature`)
10. **Open a Pull Request** against the `main` branch

## Development Setup

```bash
# Clone your fork
git clone https://github.com/YOUR-USERNAME/laravel-otp.git
cd laravel-otp

# Install dependencies
composer install

# Run tests
composer test

# Check code style
composer lint

# Run static analysis
composer analyze
```

## Coding Standards

- Follow **PSR-12** coding standards
- Add **docblocks** for all public methods
- Include **type hints** for parameters and return types
- Write **comprehensive tests** for new features
- Maintain **backward compatibility** when possible

## Testing Guidelines

- Use Orchestra Testbench for Laravel integration tests
- Aim for high test coverage
- Test edge cases and error conditions
- Use descriptive test method names

## Documentation

- Update README.md for new features
- Add examples for new functionality
- Update CHANGELOG.md following [Keep a Changelog](https://keepachangelog.com/)

## Code of Conduct

- Be respectful and inclusive
- Provide constructive feedback
- Help others learn and grow

## Questions?

Open an issue with the `question` label or reach out to the maintainers.

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
