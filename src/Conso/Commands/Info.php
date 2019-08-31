<?php

namespace Conso\Commands;

/**
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.2.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Command;
use OoFile\Conf;
use Conso\Contracts\CommandInterface;
use Conso\Exceptions\NotFoundException;

class Info extends Command implements CommandInterface
{
    /**
     * available command flags.
     *
     * @var array
     */
    protected $flags = ['-c', '--commands'];

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'Display console information.';

    /**
     * execute command and sub commands.
     *
     * @param string $commands
     */
    public function execute($sub, $options, $flags) //here rather then found commands we pass the commands in others we pas the sub command
    {
        $this->displayCommands($flags);
        $this->logo();
        $this->basicInfo();
        $this->displayAvailableCommands(); // from parent
    }

    /**
     * output app loglo method.
     */
    public function logo()
    {
        $logo = Conf::conso('APP_LOGO_FILE');

        if (!file_exists($logo)) {
            throw new NotFoundException("Logo file $logo not found !");
        }
        $content = file_get_contents($logo);
        $this->output->writeLn($content);
    }

    /**
     * display basic app infp method.
     */
    public function basicInfo()
    {
        $this->output->writeLn(Conf::conso('APP_NAME'), 'yellow');
        $this->output->writeLn(' version '.Conf::conso('APP_VERSION'));
        $this->output->writeLn(' '.Conf::conso('APP_RELEASE_DATE')."\n\n", 'green');
        $this->output->writeLn("Usage :\n\n", 'yellow');
        $this->output->writeLn("  command:subcommand [options] [flags] \n\n");
        $this->output->writeLn("Options, flags :\n\n", 'yellow');
        $this->optionsAndFlags('-h, --help', '           Display this help message.');
        $this->optionsAndFlags('-q, --quiet', '          Do not output any message.');
        $this->optionsAndFlags('-v, --version', '        Display this application version.');
        $this->optionsAndFlags('-c, --commands', '       Display available application commands.');
        $this->optionsAndFlags('    --ansi', '           Enable ANSI output.');
        $this->optionsAndFlags('    --no-ansi', '        Disable ANSI output.');
        $this->optionsAndFlags('-n, --no-interaction', ' Do not ask any interactive question.');
        $this->optionsAndFlags('    --profile', "        Display timing and memory usage information.\n");
    }

    /**
     * display default options and flags.
     *
     * @param string $options
     * @param string $message
     */
    public function optionsAndFlags($options, $message)
    {
        $this->output->writeLn("  $options", 'green');
        $this->output->writeLn('       ');
        $this->output->writeLn("$message\n");
    }

    /**
     * display basic help.
     */
    public function help()
    {
        $this->output->writeLn("\n[ Info ]\n\n", 'yellow');
        $this->basicInfo();
        exit(1);
    }

    /**
     * dispay help commands.
     *
     * @param string $flag
     */
    public function displayCommands($flags)
    {
        if ($this->input->flags(0)) {
            if (in_array($flags[0], $this->flags)) {
                if ($flags[0] == '-c' || $flags[0] == '--commands') {
                    $this->output->writeLn("\n");
                    $this->displayAvailableCommands();
                    die;
                }
            }
        }
    }
}
