# ![logo](http://i.imgur.com/YL5RZv5.png) Owl

Owl is a simply cURL wrapper for PHP

[![Build Status](https://travis-ci.org/pablosanches/owl.svg?branch=master)](https://travis-ci.org/pablosanches/owl)
[![CodeClimate](http://img.shields.io/codeclimate/github/pablosanches/owl.svg?style=flat)](https://codeclimate.com/github/pablosanches/owl)
[![Version](http://img.shields.io/packagist/v/pablosanches/owl.svg?style=flat)](https://packagist.org/packages/pablosanches/owl)

## Requirements

* PHP >= 5.6
* [cURL](http://php.net/manual/fr/book.curl.php/) library enabled

## Install

### Composer

```js
{
    "require": {
        "pablosanches/owl": "1.0.*"
    }
}
```

```php
require_once './vendor/autoload.php';
```

## Usage

```php
// Namespace shortcut
use Owl\Method as Http;

// Template
$request = new Http\<METHOD_NAME>( string $url [, array $options ] );
```

Methods are:

* `Get()`
* `Head()`
* `Options()`
* `Post()`
* `Put()`
* `Patch()`
* `Delete()`

### Constructor `$options`

```php
[
    'data' => [             // Data to send, available for `Post`, `Put` and `Patch`
        'foo' => 'bar'
    ],
    'headers' => [          // Additional headers (optional)
        'Authorization: foobar'
    ],
    'ssl' => '/cacert.pem', // Use it for SSL (optional)
    'is_payload' => true,   // `true` for sending a payload (JSON-encoded data, optional)
    'autoclose' => true     // Is the request must be automatically closed (optional)
]
```

### Public methods

```php
// Send a request
$request->send();

// HTTP status code
$request->getStatus();

// HTTP header
$request->getHeader();

// HTTP body response
$request->getResponse();

// Used cURL options
$request->getCurlOptions();

// Set a cURL option
$request->setCurlOption(CURLOPT_SOMETHING, $value);

// Manually close the handle (necessary when `autoclose => false` is used)
$request->close();
```

### Examples

Basic:

```php
// Namespace shortcut
use Owl\Method as Http;

// Standard GET request
$request = new Http\Get('http://domain.com');

// Send this request
$request->send();

echo $request->getResponse(); // body response
echo $request->getStatus(); // HTTP status code
```

Send a payload:

```php
// Namespace shortcut
use Owl\Method as Http;

// JSON-encoded POST request
$request = new Http\Post($this->endpoint, [
    'data' => [
        'name' => 'foo',
        'email' => 'foo@domain.com'
    ],
    // With 'is_payload' => true
    // You don't have to json_encode() your array of data
    // Moreover, the appropriate headers will be set for you
    'is_payload' => true
]);

// Send this request
$request->send();

echo $request->getResponse(); // body response
echo $request->getStatus(); // HTTP status code
```

Manual closing:

```php
// Namespace shortcut
use Owl\Method as Http;

// Set `autoclose` option to `false`
$request = new Http\Get('http://domain.com', [
    'autoclose' => false
]);

// Send this request
$request->send();

// Now you can retrieve a cURL info as the handle is still open
$request->getCurlInfo(CURLINFO_SOMETHING);

echo $request->getResponse();

// Manually close the handle
$request->close();
```

## Tests

On project directory:

* `composer install` to retrieve `phpunit`
* `phpunit` to run tests
