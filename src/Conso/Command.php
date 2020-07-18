<?php

namespace Conso;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.0.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Contracts\InputInterface;
use Conso\Contracts\OutputInterface;

/**
 * This class is base command class.
 */
class Command
{
    /**
     * base constructor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param Conso           $app
     */
    public function __construct(InputInterface $input, OutputInterface $output, Conso $app)
    {
        if ($input->flag(0) == '--no-ansi') {
            $output->disableAnsi();
        }

        //if($input->flag(0) == '-q' || $input->flag(0) == '--quiet'); // if quiet flag

        if ($input->flag(0) == '-h' || $input->flag(0) == '--help') {
            $this->displayCommandHelp($input, $output, $app);
        }
    }

    /**
     * display help for a given command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param Conso           $app
     *
     * @return void
     */
    protected function displayCommandHelp($input, $output, $app)
    {
        $name = $app->activeCommand['name'];
        $help = $app->activeCommand['help'];

        $output->writeLn("\n help for [".$name."] command:\n\n", 'yellow');

        $output->writeLn("    php conso $name:{sub command} {options}\n\n");

        if (is_array($help) && count($help) > 0) {
            foreach ($help as $key => $value) {
                $output->writeLn('      ['.$key."]\n\n", 'yellow');

                foreach ($value as $a => $b) {
                    $output->writeLn('          '.$a.' : '.$b."\n\n");
                }
            }
        }
        exit;
    }
}
