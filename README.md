# Rate Limiter package for Laravel

[![Build Status](https://travis-ci.org/cschalenborgh/laravel-rate-limiter.svg?branch=master)](https://travis-ci.org/cschalenborgh/laravel-rate-limiter)
[![StyleCI](https://github.styleci.io/repos/197462301/shield?branch=master)](https://github.styleci.io/repos/197462301)
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

```php
$rate_limiter = new RateLimit('action_name', 5, 60); // max 5 times in 60 seconds

if ($rate_limiter->check($lock_identifier)) {
    // perform some action
} else {
    // oops.. limit reached
}
```