# Markix for Laravel

## Introduction

Markix for Laravel is our first-party Laravel integration. It's the fastest way to start sending emails with Markix in your Laravel application.

## Installation

To use the Markix driver, install the mailer transport via Composer:

```bash
composer require markix/markix-laravel
```

Then, add the following option to your `config/mail.php` configuration file:

```php
'markix' => [
    'transport' => 'markix',
],
```

Next, either set the `default` option in your application's `config/mail.php` configuration file to `markix`, or update the `MAIL_MAILER` environment variable in your application's `.env` file:

```ini
MAIL_MAILER=markix
```

After configuring your application's default mailer, verify that your `config/services.php` configuration file contains the following options:

```php
'markix' => [
    'token' => env('MARKIX_TOKEN'),
],
```

Finally, add your Markix API test token to your local `.env` file. If you're deploying to production you should use your live API token instead:

```ini
MARKIX_TOKEN=test_....
```

## License
Markix for Laravel is open-sourced software licensed under the MIT license.
