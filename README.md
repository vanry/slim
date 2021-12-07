# Slim Framework 4 Skeleton Application

Use this skeleton application to quickly setup and start working on a new Slim Framework 4 application.

It uses only a few packages to keep it minimal:

* `hassankhan/config` access configuration
* `monolog/monolog` log errors and exceptions
* `pimple/pimple` as dependency contain
* `slim/php-view` as template engine

## Requirements

* PHP 7.3+ or 8.0+

## Installation

```bash
composer create-project vanry/slim [my-app-name]
```

Replace `[my-app-name]` with the desired directory name for your new application or leave it empty.

You'll want to:

* Point your virtual host document root to your new application's `public` directory.
* Ensure  `storage` directory is web writable.

## Start

To run the application in development, you can run these commands

```bash
cd [my-app-name]

composer serve
```

After that, open `http://localhost:8000` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

Additonal test methods are in `tests/TestCase.php`, you are not limited to add your own.

That's it! Now go build something cool.

## License

It is open-sourced software licensed under the MIT license.
