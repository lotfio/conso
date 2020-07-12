<p align="center">
  <img src="https://user-images.githubusercontent.com/18489496/51750637-f351c280-20b2-11e9-97e3-f1e0232bb04a.png"  alt="Conso Preview">
  <p align="center">
    <img src="https://img.shields.io/badge/License-MIT-f1c40f"          alt="License">
    <img src="https://img.shields.io/badge/PHP-7.2-3498db.svg"          alt="PHP version">
    <img src="https://img.shields.io/badge/version-0.2.0-2c3e50.svg"    alt="Version">
    <img src="https://img.shields.io/badge/coverage-40%25-27ae60.svg"   alt="Coverage">
    <img src="https://travis-ci.org/lotfio/conso.svg?branch=master"     alt="Build Status">
    <img src="https://github.styleci.io/repos/165832668/shield?branch=master" alt="StyleCi">
    <img src="https://img.shields.io/badge/downloads-1k-e74c3c.svg"     alt="Downloads">
    </p>
  <p align="center">
    <strong>Conso (PHP console applications for geeks).</strong>
  </p>
</p>

## 🔥 Introduction :
Conso is a simple, lightweight PHP package that helps you create command line applications easily.

![conso-php](https://user-images.githubusercontent.com/18489496/51997787-b4a77800-24b7-11e9-9016-daff3f7216fc.gif)

## 📌 Requirements :
- PHP 7.2 or newer versions
- PHPUnit >= 8 (for testing purpose)

## 🚀 Installation :
* ***Via composer :***

```php
composer require lotfio/conso
```

## 🚀 write your first command
- create a conso file
- it should look something like this

```php
    #!/usr/bin/env php
    <?php declare(strict_types=1);

    use Conso\{
        Conso,Input,Output
    };

    require 'vendor/autoload.php';

    $conso = new Conso(new Input, new Output);

    // you commands should be registered here before you run the app

    $conso->command("test", function($input, $output){
        $output->writeLn("hello from test ", 'red');
    });

    $conso->run(0);
```


## 🔧 Configure Conso


## ✨ TODO

Helpers for quick commands development.

## ✨ Contributing

Thank you for considering to contribute to Conso. All the contribution guidelines are mentioned **[Here](CONTRIBUTE.md)**.

## 💖 Support

If this project helped you reduce time to develop, you can give me a cup of coffee :) : **[Paypal](https://www.paypal.me/lotfio)**.

## ✨ License

Conso is an open-source software licensed under the **[MIT license](LICENCE)**.
