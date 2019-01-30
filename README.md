# PHP command line made easy.
#
![logi](https://user-images.githubusercontent.com/18489496/51750637-f351c280-20b2-11e9-97e3-f1e0232bb04a.png)

![Licence](https://img.shields.io/badge/Licence-MIT-f1c40f.svg)
![PHP7](https://img.shields.io/badge/PHP-7.2-3498db.svg)
![version](https://img.shields.io/badge/version-0.1.0-27ae60.svg)
![build](https://img.shields.io/badge/build-passing-8e44ad.svg)
![coverage](https://img.shields.io/badge/coverage-40%25-27ae60.svg)
![downloads](https://img.shields.io/badge/downloads-10k-c0392b.svg)
### Introduction :
Conso is a simple, lightweight PHP package that helps you create command line applications easily.

![conso-php](https://user-images.githubusercontent.com/18489496/51997787-b4a77800-24b7-11e9-9016-daff3f7216fc.gif)

### Requirements :
- PHP 7.2 or newer versions

### Installation :
- Via composer :

```php
composer require lotfio/conso
```

# Create your first command :
```php
php conso command:make {command name}
```
* This commad wil create a command file located inside `src/Conso/Commands/Yourcommand.php`
* Now just navigate to your command file and customize it.
***Your command file will look like this :***
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
     * command execute method
     * 
     * @param  string $sub sub command (command after colone)
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
     * command description method
     *  
     * @return string
     */
    public function description() { return "command description.";}

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
* You can create Helper classes inside `Helpres` folder and use them with your commands.
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
   $this->output->error($string): // also warnining() + success() which will output to STDOUT with colors but on windowns no ansi support so will not output colors.
   $this->output->timer(); // output timer [#### .......]
   this->output->whiteSpace($number); // output white spaces based on the given number
```

#TODO 

Helpers for quick commands development.


# Contributing

Thank you for considering to contribute to Aven. All the contribution guidelines are mentioned **[Here](CONTRIBUTE.md)**.

# Support 

If this project helped you reduce time to develop, you can give me a cup of coffee :) : **[Paypal](https://www.paypal.me/lotfio)**.

# License

Aven is an open-source software licensed under the **[MIT license](LICENCE)**.