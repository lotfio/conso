<p align="center">
  <img src="https://user-images.githubusercontent.com/18489496/51750637-f351c280-20b2-11e9-97e3-f1e0232bb04a.png"  alt="Conso Preview">
  <p align="center">
    <img src="https://img.shields.io/badge/License-MIT-f1c40f"          alt="License">
    <img src="https://img.shields.io/badge/PHP-7.2-3498db.svg"          alt="PHP version">
    <img src="https://img.shields.io/badge/version-2.0.0-2c3e50.svg"    alt="Version">
    <img src="https://img.shields.io/badge/coverage-40%25-27ae60.svg"   alt="Coverage">
    <img src="https://travis-ci.org/lotfio/conso.svg?branch=master"     alt="Build Status">
    <img src="https://github.styleci.io/repos/165832668/shield?branch=master" alt="StyleCi">
    <img src="https://img.shields.io/badge/downloads-1k-e74c3c.svg"     alt="Downloads">
    </p>
  <p align="center">
    <strong>Conso (PHP console applications for cool kids).</strong>
  </p>
</p>

## 🔥 Introduction :
Conso is a simple, lightweight PHP package that helps you create (executable, `.phar`, shareable) command line applications easily.

![conso](https://user-images.githubusercontent.com/18489496/91354364-8a798180-e7e4-11ea-8f47-2b67580aee02.gif)

## :collision: Is it really lightweight ?
<img width="825" alt="Screen Shot 2020-07-27 at 6 12 41 PM" src="https://user-images.githubusercontent.com/18489496/88639724-616ab180-d0bd-11ea-873a-2e25ea1fa113.png">

## 📌 Requirements :
- PHP     >= 7.2 or newer versions
- PHPUnit >= 8 (for testing purpose)

## 🚀 Installation :
* ***Via composer :***

```php
composer require lotfio/conso
```

* ***for testing***
```php
composer test
```

## 🎉 Write your first command
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

$conso->run();
```

### :star: Available config methods :

```php
<?php

$conso->setSignature(); // set application signature (top logo)
$conso->setName();     // set application name
$conso->setVersion(); // set application version
$conso->setAuthor(); // set application author
$conso->disableBuiltInCommands(); // disable builtin commands

```

- now define a new `test` command in your `commands.php` :

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


### :star: Add description
- `->description(string $description)`;

```php
<?php
// test command
$conso->command("test", function($input, $output){
    $output->writeLn("\n hello from test \n", 'red');

})->description("This is test command description :) ^^");
```
![description](https://user-images.githubusercontent.com/18489496/87862367-89387780-c94f-11ea-8166-6fc9bc598fdd.png)


### :star: Define sub commands
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


### :star: Define command flags
- you can define flags using the flag method `->flags(string|array $flag)`
- this is a list of reserved flags `['-h', '--help', '-v', '--version', '-c', '--commands', '-q', '--quiet', '--ansi', '--no-ansi']`
- for debug you can use `-vv or --verbose` flags to get more details about the error
- you can also pass values to flags `--flag=value` or `-f=value`

```php
<?php
// test command
$conso->command("test", function($input, $output){

    if($input->flag('-t') !== false)
        $output->writeLn("\n flag -t is defined for this command.\n", 'red');

    // you can get flag values
    // $output->writeLn($input->flag('-t'));

})->description("This is test command description :) ^^")->flags('-t');
```

![image](https://user-images.githubusercontent.com/18489496/87862405-095edd00-c950-11ea-9cd7-f26b2823981f.png)


### :star: Add command alias
- you can add an alias to a command with the alias method  `->alias(string $alias)`

```php
<?php
// test command
$conso->command("test", function($input, $output){

    $output->writeLn("\n test called by alias \n", 'red');

})->description("This is test command description :) ^^")->alias('alias');
```

![image](https://user-images.githubusercontent.com/18489496/87862421-21cef780-c950-11ea-8a08-adf0efcab72e.png)


### :star: Define command help
- you can add help instructions to a command using the help method `->help(array $help)`
- command help can be displayed using the `-h` or `--help` flags
- help array must be an array of sub commands, options and flags with their descriptions
```php
<?php
// test command
$conso->command("test", function($input, $output){

    $output->writeLn("\n test called by alias \n", 'red');

})->description("This is test command description :) ^^")->sub('one')->flags('-t')

  ->help([
      "sub commands" => [
          "one" => " help text for sub command goes here"
        ],
      "flags" => [
          "-t" => "help text for flag goes here"
        ]
  ]);
```
![image](https://user-images.githubusercontent.com/18489496/88392798-e94e7400-cdbc-11ea-8de6-5fab02cdfb01.png)


### :star: Group commands
 - you can group commands using the `group()` method
```php
<?php

$conso->group('my group of commands:', function($conso){

    $conso->command("command", function(){})->description('This is command description');
    $conso->command("test",    function(){})->description('This is command description');
    $conso->command("make",    function(){})->description('This is command description');

});

```
![image](https://user-images.githubusercontent.com/18489496/88970755-3fd31b00-d2b3-11ea-9860-2ff024a6a2dc.png)

### :star: Class commands
- class commands are very helpful for big commands
- first you need to create an `app/Commands` folder.
- you can also move your commands definitions file `commands.php` to `app` folder to clean up things.
- don't forget to autoload your commands with composer `psr-4{ "App\\" : "app" }`
- now you need add commands paths and namespaces to conso to allow the build in command (command) to automatically create commands for you.

```php
    // add this to your conso file before run method
    $conso->setCommandsPath('app/Commands');
    $conso->setCommandsNamespace('App\\Commands');
```
- to create a class command run `php conso command:make {command name}`
- for example lets create a test class command `php conso command:make test`
- this will generate a `Test` command class like this:

```php
<?php

namespace App\Commands;

use Conso\{Conso, Command};
use Conso\Contracts\{CommandInterface,InputInterface,OutputInterface};

class Test extends Command implements CommandInterface
{
    /**
     * sub commands
     *
     * @var array
     */
    protected $sub  = [

    ];

    /**
     * flags
     *
     * @var array
     */
    protected $flags = [

    ];

    /**
     * command help
     *
     * @var array
     */
    protected $help  = [

    ];

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
    public function execute(InputInterface $input, OutputInterface $output) : void
    {
        commandHelp($this->app->invokedCommand, $output);
    }
}
```
- now you need to register this command in your `commands.php` file:
```php

$conso->command('test', Your\NameSpace\Test::class);

```
- by default `test` command will run the `execute` method if no sub command is provided
- each sub command is a separate method

## :star: Accessing app from commands :
 - from a callback command

```php
<?php

// test command
$conso->command("test", function($input, $output){

    // get app config
    $this->getName();
    $this->getVersion();
    $this->getAuthor();
    $this->getCommandsPath();
    $this->getCommandsNamespace();

    // calling another command
    $this->call('command:subcommand -f --flags');
});

```
 - from a class command

```php
<?php

    /**
     * execute method
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output) : void
    {
        // get app config
        $this->app->getName();
        $this->app->getVersion();
        $this->app->getAuthor();
        $this->app->getCommandsPath();
        $this->app->getCommandsNamespace();

        // calling another command
        $this->app->call('command:subcommand -f --flags');
    }

```
### :star: Commands namespace
 - you can wrap commands in the same namespace with `namespace()` method which makes things cleaner

```php
<?php

$conso->namespace('Conso\\Commands', function($conso){

    // all commands withing Conso\Commands namespace
    $conso->command("command", Command::class);
    $conso->command("test",    Test::class);
    $conso->command("make",    Make::class);

});

```

### :star: Http support
- you can invoke conso from the browser or any http client just by passing commands to the input instance
```php
<?php declare(strict_types=1);

use Conso\{
    Conso,Input,Output
};

require 'vendor/autoload.php';

// you can sanitize and pass your command her
$command = 'command:make HttpCommand';

$input   = new Input($command);

$conso   = new Conso($input, new Output);

require 'commands.php';

$conso->run();

```
### :star: Compile your app to an executable shareable single `.phar` file :
- you can use this feature from version `2.0` and above.
- to compile your application and create a shareable `.phar` file use the built in `compile` command.
- run `php conso compile:init` to create a `conso.json` build file.

![compile:init](https://user-images.githubusercontent.com/18489496/91350990-68313500-e7df-11ea-8fe2-e0ed1db373af.png)

- this will generate a json file like follow:
```js
{
    "src": [ /* your pacakge directories to compile should be added here */
        "src\/Conso", 
        "vendor" /* package dependencies if any */
    ],
    "build": "build", /* build location */
    "stub": "conso",  /* stub file (the entry point of your phar) */
    "phar": "conso.phar" /* output (your phar file name) */
}

```
- your stub file should look something like this:

```php
<?php // no need for shebang it will be added automatically 

declare(strict_types=1);

use Conso\{
    Conso,Input,Output
};

require 'vendor/autoload.php';

$conso = new Conso(new Input, new Output);

$conso->setName("app name");
$conso->setVersion("2.0.0");

$conso->setSignature(" app signature ");

$conso->disableBuiltInCommands(); // disable conso built in commands

// include your commands
// require 'app/commands.php';

$conso->run();
```
- now you can run `php conso compile` and you will get your package compiled to a `phar` file.

![compiled](https://user-images.githubusercontent.com/18489496/91352004-1ab5c780-e7e1-11ea-8535-5d1260656720.png)

- you can use `--no-shebang` flag to avoid adding shebang to your `phar` file (this is useful if you want to invoke your `phar` file from `http`)


### :star: Testing helpers:
- you can use `Conso\Testing\TestCase` test helper class for testing which helps you to :
    - turn on testing mode for you (return results instead of outputing to STDOUT).
    - disable ansi colors which is not needed when testing.

## ✨ Todo
- improve code quality.

## ✨ Contributing

Thank you for considering to contribute to Conso. All the contribution guidelines are mentioned **[Here](CONTRIBUTE.md)**.

## 💖 Support

If this project helped you reduce time to develop, you can give me a cup of coffee :) : **[Paypal](https://www.paypal.me/lotfio)**.

## ✨ License

Conso is an open-source software licensed under the **[MIT license](LICENCE)**.
