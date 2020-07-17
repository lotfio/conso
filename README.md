<p align="center">
  <img src="https://user-images.githubusercontent.com/18489496/51750637-f351c280-20b2-11e9-97e3-f1e0232bb04a.png"  alt="Conso Preview">
  <p align="center">
    <img src="https://img.shields.io/badge/License-MIT-f1c40f"          alt="License">
    <img src="https://img.shields.io/badge/PHP-7.2-3498db.svg"          alt="PHP version">
    <img src="https://img.shields.io/badge/version-1.0.0-2c3e50.svg"    alt="Version">
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

![conso-php](https://user-images.githubusercontent.com/18489496/87257339-7b3fae00-c49a-11ea-9246-74368e320385.gif)

## 📌 Requirements :
- PHP     >= 7.2 or newer versions
- PHPUnit >= 8 (for testing purpose)

## 🚀 Installation :
* ***Via composer :***

```php
composer require lotfio/conso
```

## 🎉 write your first command
- create a `commands.php` file.
- create a `conso` file (you can change the name as you like).
- include your `commands.php` file into `conso` executable file.
- it should look something like this.

```php
#!/usr/bin/env php
<?php declare(strict_types=1);

use Conso\{
    Conso,Input,Output
};

require 'vendor/autoload.php';

$conso = new Conso(new Input, new Output);

// include your commands
require_once 'commands.php';

$conso->run(0); // 0 for production & 1 for development
```
- define a new `test` command in your `commands.php` :

```php
<?php
// this is your commands file

 // test command
$conso->command("test", function($input, $output){
    $output->writeLn("\n hello from test \n", 'red');
});

```

- now your command has been registered.
- run `php conso --commands` or `./conso --commands` in your terminal and you should see your command.

![commands](https://user-images.githubusercontent.com/18489496/87434186-6f630180-c5ea-11ea-894a-7efaaad6301f.png)

- command test is registered now ***(no description is shown you can add this later on)***.
- run your command `php conso test` or `./conso test`.

![image](https://user-images.githubusercontent.com/18489496/87434691-12b41680-c5eb-11ea-9d36-656c33fd18b7.png)


### add description
- `->description(string $description)`;

```php
<?php
// test command
$conso->command("test", function($input, $output){
    $output->writeLn("\n hello from test \n", 'red');

})->description("This is test command description :) ^^");
```
![named](https://user-images.githubusercontent.com/18489496/87438178-80624180-c5ef-11ea-802e-db500ebb8329.png)


### define sub commands
- `->sub(string|array $subCommand)`;

```php
<?php
// test command
$conso->command("test", function($input, $output){

    if($input->subCommand() == 'one')
        exit($output->writeLn("\n hello from one \n", 'yellow'));

    if($input->subCommand() == 'two')
        $output->writeLn("\n hello from two \n", 'green');

})->description("This is test command description :) ^^")->sub('one', 'two');
```
![image](https://user-images.githubusercontent.com/18489496/87439833-8527f500-c5f1-11ea-9b55-56746b0a66cc.png)

![image](https://user-images.githubusercontent.com/18489496/87439882-96710180-c5f1-11ea-8da2-188afd6294c0.png)


### define command flags
- you can define flags using the flag method `->flags(string|array $flag)`
- this is a list of reserved flags `['-h', '--help', '-v', '--version', '-c', '--commands', '-q', '--quiet', '--ansi', '--no-ansi']`

```php
<?php
// test command
$conso->command("test", function($input, $output){

    if($input->flag(0) == '-t')
        $output->writeLn("\n flag -t is defined for this command.\n", 'red');

})->description("This is test command description :) ^^")->flags('-t');
```

![image](https://user-images.githubusercontent.com/18489496/87725819-498e5600-c7be-11ea-94a8-dfb566218129.png)


### add command alias
- you can add an alias to a command with the alias method  `->aliad(string $alias)`

```php
<?php
// test command
$conso->command("test", function($input, $output){

    $output->writeLn("\n test called by alias \n", 'red');

})->description("This is test command description :) ^^")->alias('alias');
```

![image](https://user-images.githubusercontent.com/18489496/87726841-1d73d480-c7c0-11ea-912d-df22f7c9723f.png)


### define command help
- you can add help instruction to a command using the help method `->help(array $help)`
- command help can be displayed using the `-h` or `--help` flags
- help array must be an array of sub commands and options with their descriptions
- help method is not is predefined for `class commands` but not for `closure commands` so you need to implement it your self

```php
<?php
// test command
$conso->command("test", function($input, $output){

    $output->writeLn("\n test called by alias \n", 'red');

})->description("This is test command description :) ^^")->sub('one')->flags('-t')

  ->help(array(
      "sub commands" => array(
          "one" => " help text for sub command goes here"
      ),
      "flags" => array(
          "-t" => "help text for flag goes here"
      )
  ));
```
![image](https://user-images.githubusercontent.com/18489496/87726841-1d73d480-c7c0-11ea-912d-df22f7c9723f.png)

### class commands
- class commands are very helpful for big commands
- configure class commands (path & namespace)
```php
    // add this to your conso file before run method
    $conso->setCommandsPath('path');
    $conso->setCommandsNamespace('namespace');
```

- to create a class command run `php conso command:make {command name}`
- for example lest create a test class command `php conso command:make test`
- this will generate a `Test` command class like this:

```php
<?php

namespace Conso\Commands;

use Conso\Conso;
use Conso\Command as BaseCommand;
use Conso\Exceptions\InputException;
use Conso\Contracts\{CommandInterface,InputInterface,OutputInterface};

class Test extends BaseCommand implements CommandInterface
{
    /**
     * sub commands
     *
     * @var array
     */
    protected $sub = array(
    );

    /**
     * flags
     *
     * @var array
     */
    protected $flags = array(
    );

    /**
     * command description
     *
     * @var string
     */
    protected $description = 'This is Test command description.';

    /**
     * command help
     *
     * @var string
     */
    protected $help        = 'This is Test command help message.';

    /**
     * execute method
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output, Conso $app) : void
    {
        $this->displayCommandHelp($input, $output, $app);
    }
}
```
- now you need to register this command in your `commands.php` file:
```php

    $conso->command('test', 'Your\\Name\\Space\\Test');

```
- by default `test` command will run the `execute` method if no sub command is provided



## ✨ TODO
- implement help in closure commands
- call command from another command method

Helpers for quick commands development.

## ✨ Contributing

Thank you for considering to contribute to Conso. All the contribution guidelines are mentioned **[Here](CONTRIBUTE.md)**.

## 💖 Support

If this project helped you reduce time to develop, you can give me a cup of coffee :) : **[Paypal](https://www.paypal.me/lotfio)**.

## ✨ License

Conso is an open-source software licensed under the **[MIT license](LICENCE)**.