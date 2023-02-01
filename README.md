**Notice:** This package is still under development and is not production ready. Available components and api may change at any time without a major version change; use at your own risk.

# blade

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rawilk/blade.svg?style=flat-square)](https://packagist.org/packages/rawilk/blade)
![Tests](https://github.com/rawilk/blade/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/rawilk/blade.svg?style=flat-square)](https://packagist.org/packages/rawilk/blade)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/rawilk/blade?style=flat-square)](https://packagist.org/packages/rawilk/blade)
[![License](https://img.shields.io/github/license/rawilk/blade?style=flat-square)](https://github.com/rawilk/blade/blob/main/LICENSE.md)

![social image](https://banners.beyondco.de/blade.png?theme=light&packageManager=composer+require&packageName=rawilk%2Fblade&pattern=linesInMotion&style=style_1&description=Commonly+needed+blade+components+for+Laravel+apps.&md=1&showWatermark=0&fontSize=100px&images=code)

Blade is a package that provides blade components for common elements you may need in an application. The components are built and optimized for Tailwind CSS, Laravel Livewire, and Alpine.js, however they can be styled and used differently.

## Installation

You can install the package via composer:

```bash
composer require rawilk/blade
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="blade-config"
```

You can view the default configuration here: https://github.com/rawilk/blade/blob/main/config/blade.php

## Usage

Here is an example of how you can render a button element using the `button` component:

```html
<x-blade::button.button color="blue" wire:click="update">
    Click me
</x-blade::button.button>
```

This will render a button with a background color of blue. Since a `wire:click` is specified, our button component will automatically add a loading indicator inside the button that will be shown when while waiting for the server to finish the request.

> Note: The button component, along with may other components, can also be referenced with its alias defined in the config file. For example, you can use `x-button` instead of `x-blade::button.button`.

Further documentation will be coming in the future for further usage on each of the components.

## Scripts

### Setup

For convenience, you can run the setup bin script for easy installation for local development.

```bash
./bin/setup.sh
```

### Formatting

Although formatting is done automatically via workflow, you can format php code locally before committing with a composer script:

```bash
composer format
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [my security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

-   [Randall Wilk](https://github.com/rawilk)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
