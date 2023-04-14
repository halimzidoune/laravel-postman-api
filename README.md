# Export your Laravel API Routes into a postman Collection.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/halimzidoune/laravel-postman-api.svg?style=flat-square)](https://packagist.org/packages/halimzidoune/laravel-postman-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/halimzidoune/laravel-postman-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/halimzidoune/laravel-postman-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/halimzidoune/laravel-postman-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/halimzidoune/laravel-postman-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/halimzidoune/laravel-postman-api.svg?style=flat-square)](https://packagist.org/packages/halimzidoune/laravel-postman-api)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

With this command `php artisan routes:export collection_name`, a json file will be generated and can be imported from postman, for a good separation between the modules folders and subfolders tree will be generated , this division is based on the paths of the urls.

In `POST` and `PUT` Methods, if the controller action use a FormRequest, all rules attributes will be extracted and created in postman body request.

<img src="https://github.com/halimzidoune/laravel-postman-api/blob/main/laravel-api-to-postman-featured.png" width="100%" />


## Installation

You can install the package via composer:

```bash
composer require halimzidoune/laravel-postman-api
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="postman-api-config"
```

This is the contents of the published config file:

```php
return [
    'base_url' => 'http://localhost:8000', // API Host url
    'export_folder' => 'postman', // The destination folder where the collection.json file will be geneated
];
```

## Usage

```bash
php artisan routes:export collection_name
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [zidoune halim](https://github.com/halimzidoune)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
