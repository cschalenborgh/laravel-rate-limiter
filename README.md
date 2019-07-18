# Rate Limiter package for Laravel

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

# Description

You can use this package to easily rate limiter specific logic in your Laravel application, from Guzzle requests, to more specific application logic.
This package is based on https://github.com/touhonoob/RateLimit.

## Installation

You can install the package via composer:

``` bash
composer require cschalenborgh/laravel-rate-limieter
```

The service provider will automatically get registered. Or you may manually add the service provider in your config/app.php file:

```php
'providers' => [
    // ...
    Cschalenborgh\RateLimiter\RateLimiterServiceProvider::class,
];
```

## Usage

todo