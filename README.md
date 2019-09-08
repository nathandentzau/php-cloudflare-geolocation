# PHP Cloudflare Geolocation

A library that assists in retrieving the continent and country information from
Cloudflare's request headers.

## How to Install

You can install this library with [Composer][]:

```bash
$ composer require nathandentzau/cloudflare-geolocation
```

## Dependencies

* PHP 7.2+
* [Symfony HTTP Foundation][] component.

## How to Use

### Get the current user's continent

```php
<?php

use NathanDentzau\CloudflareGeolocation\CloudflareGeolocation;
use Symfony\Component\HttpFoundation\Request;

$request = Request::create();
$geolocation = new CloudflareGeolocation($request);

/** @var \NathanDentzau\CloudflareGeolocation\Continent */
$continent = $geolocation->getCurrentContinent();
```

### Get the current user's country

```php
<?php

use NathanDentzau\CloudflareGeolocation\CloudflareGeolocation;
use Symfony\Component\HttpFoundation\Request;

$request = Request::create();
$geolocation = new CloudflareGeolocation($request);

/** @var \NathanDentzau\CloudflareGeolocation\Country */
$country = $geolocation->getCurrentCountry();
```

### Get the current user's connecting IP address

```php
<?php

use NathanDentzau\CloudflareGeolocation\CloudflareGeolocation;
use Symfony\Component\HttpFoundation\Request;

$request = Request::create();
$geolocation = new CloudflareGeolocation($request);

$ipAddress = $geolocation->getConnectingIp();
```

## License

This project is licensed under the [MIT License][].

[Composer]: https://getcomposer.org
[Symfony HTTP Foundation]: https://github.com/symfony/http-foundation
[MIT License]: LICENSE
