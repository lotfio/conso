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

![conso](https://user-images.githubusercontent.com/18489496/87862253-622d7600-c94e-11ea-8aef-1a79a70e8ff6.gif)

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

![test-command](https://user-images.githubusercontent.com/18489496/87862304-c18b8600-c94e-11ea-9237-56895f15245a.png)

- command test is registered now ***(no description is shown you can add this later on)***.
- run your command `php conso test` or `./conso test`.

![run-test](https://user-images.githubusercontent.com/18489496/87862317-ec75da00-c94e-11ea-9690-894c35911d81.png)


### add description
- `->description(string $description)`;

```php
<?php
// test command
$conso->command("test", function($input, $output){
    $output->writeLn("\n hello from test \n", 'red');

})->description("This is test command description :) ^^");
```
![description](https://user-images.githubusercontent.com/18489496/87862367-89387780-c94f-11ea-8166-6fc9bc598fdd.png)


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
![image](https://user-images.githubusercontent.com/18489496/87862387-abca9080-c94f-11ea-90da-cf65a0a5fbba.png)

![image](https://user-images.githubusercontent.com/18489496/87862391-bedd6080-c94f-11ea-808e-bba3738b0a4b.png)


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

![image](https://user-images.githubusercontent.com/18489496/87862405-095edd00-c950-11ea-9cd7-f26b2823981f.png)


### add command alias
- you can add an alias to a command with the alias method  `->aliad(string $alias)`

```php
<?php
// test command
$conso->command("test", function($input, $output){

    $output->writeLn("\n test called by alias \n", 'red');

})->description("This is test command description :) ^^")->alias('alias');
```

![image](https://user-images.githubusercontent.com/18489496/87862421-21cef780-c950-11ea-8a08-adf0efcab72e.png)


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
![image](https://user-images.githubusercontent.com/18489496/87862665-e71a8e80-c952-11ea-8393-3d8815a2cc85.png)

### :star: class commands
- class commands are very helpful for big commands

- first you need configure (path & namespace)
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
    protected $sub  = array(
    );

    /**
     * flags
     *
     * @var array
     */
    protected $flags = array(
    );

    /**
     * command help
     *
     * @var string
     */
    protected $help  = array(
    );

    /**
     * command description
     *
     * @var string
     */
    protected $description = 'This is Test command description.';

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
- each sub command is a separate method


## ✨ TODO
- implement help in closure commands.
- call command from another command method.


## ✨ Contributing

Thank you for considering to contribute to Conso. All the contribution guidelines are mentioned **[Here](CONTRIBUTE.md)**.

## 💖 Support

If this project helped you reduce time to develop, you can give me a cup of coffee :) : **[Paypal](https://www.paypal.me/lotfio)**.

## ✨ License

Conso is an open-source software licensed under the **[MIT license](LICENCE)**.