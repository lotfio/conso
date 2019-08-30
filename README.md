# CONSO (PHP console applications for cool kids).

![conso](https://user-images.githubusercontent.com/18489496/51750637-f351c280-20b2-11e9-97e3-f1e0232bb04a.png)

![Licence](https://img.shields.io/badge/Licence-MIT-f1c40f.svg)
![PHP7](https://img.shields.io/badge/PHP-7.2-3498db.svg)
![version](https://img.shields.io/badge/version-0.2.0-27ae60.svg)
![coverage](https://img.shields.io/badge/coverage-40%25-27ae60.svg)
![build](https://travis-ci.org/lotfio/conso.svg?branch=master)
[![StyleCI](https://github.styleci.io/repos/165832668/shield?branch=master)](https://github.styleci.io/repos/165832668)
![downloads](https://img.shields.io/badge/downloads-1k-c0392b.svg)
### Introduction :
Conso is a simple, lightweight PHP package that helps you create command line applications easily.

![conso-php](https://user-images.githubusercontent.com/18489496/51997787-b4a77800-24b7-11e9-9016-daff3f7216fc.gif)

### Requirements :
- PHP 7.2 or newer versions
- PHPUnit >= 8 (for testing purpose)

### Installation :
- Via composer :

```php
composer require lotfio/conso
```

# Configure Conso 
1- A good directory structure will look something like this:
```php
    - app
      - Commands  // your console commands 
      - conf      // your console config files

    - vendor   // conso package will be installed by composer no action needed here

    - conso  // conso executable file
```
- Now create a config file inside conf directory { for example app.php }
- Add the following configuration rules:

```php
return[

    "APP_NAME"          => "Your app name",
    "APP_VERSION"       => "Your app version",
    "APP_RELEASE_DATE"  => "Release date and info",

    "APP_LOGO_FILE"     => "logo file path",

    "COMMANDS"          => "Your commands directory name",
    "COMMANDS_NAMESPACE"=> "Your commands namespace"
];
```
2- Now load your config files with OoFile { inside you executable file conso }

```php
    use OoFile\Conf;

    Conf::add('app/conf/app.php');
```
- You can append to the default config file instead of creating your own config dir or file

```php
    // you can append to the default config array instead of creating new config file
    // you can append both strings and arrays
    Conf::append('app','COMMANDS', 'your commands dir path');
    Conf::append('app','COMMANDS', ["commands path", "commands path"]);
    Conf::append('app','NAMESPACE', 'your commands namespace');
```
- You can access your config file like this: 

```php
    Conf::app('APP_NAME'); // method name is the same as the file name
    // for example if you have a hi.php config file you will access it Conf::hi();

    //you can change config values 
    Conf::app('APP_NAME', 'value to be set here');
```

3- Don't forget to load your commands with composer

```json
    {
        "autoload" : {
            "psr-4" : {
                "app\\" : "app/"
            }
        }
    }
```

# Create your first command :
```php
php conso command:make {command name}
```
* This command wil create a command file located inside `app/Commands/YourCommand.php`
* Now just navigate to your command file and customize it.
* ***Your command file will look like this :***
```php
namespace Conso\Commands;

use Conso\Command;
use Conso\Contracts\CommandInterface;
use Conso\Exceptions\{OptionNotFoundException, FlagNotFoundException};

class YourCommand extends Command implements CommandInterface
{
    /**
     * command flags
     * 
     * @var array
     */
    protected $flags = [];

    /**
     * command description
     * 
     * @var string
     */
    protected $description = 'command description';
    
    /**
     * command execute method
     * 
     * @param  string $sub sub command (command after colon)
     * @param  array  $options command options
     * @param  array  $flags  command flags
     * @return void
     */
    public function execute(string $sub, array $options, array $flags)
    {
        //your command logic goes here 
        return $this->output->writeLn("\n\n  Welcome to YourCommand command. \n\n", "yellow");
    }

    /**
     * command help method
     *  
     * @return string
     */
    public function help() { return "command help.";}
}

```
* The execute method is where all your command logic should be executed.
* You can create helper methods withing the same command class.
# Available methods
```php
 Input methods:
    $this->input->commands($index);  // return command if found or false if not
    $this->input->options($index);  // return option if found or false if not
    $this->input->flags($index);   // return flag if found or false if not
    $this->input->commands; // return array of input commands 
    $this->input->options; // return array of input options 
    $this->input->flags; // return array of input flags 
 Output methods:
   $this->output->writeLn($string) // write to STDOUT
   $this->output->error($string): // also warning() + success() which will output to STDOUT with colors but on window's no ansi support so will not output colors.
   $this->output->timer(); // output timer [#### .......]
   $this->output->whiteSpace($number); // output white spaces based on the given number
```

# TODO 

Helpers for quick commands development.


# Contributing

Thank you for considering to contribute to Aven. All the contribution guidelines are mentioned **[Here](CONTRIBUTE.md)**.

# Support 

If this project helped you reduce time to develop, you can give me a cup of coffee :) : **[Paypal](https://www.paypal.me/lotfio)**.

# License

Aven is an open-source software licensed under the **[MIT license](LICENCE)**.
