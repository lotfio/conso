<?php  namespace Conso;

use Conso\Contracts\InputInterface;
use Conso\Contracts\OutputInterface;

/**
 * This class is base command class
 */
class Command
{
    /**
     * base constructor
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param Conso $app
     */
    public function __construct(InputInterface $input, OutputInterface $output, Conso $app)
    {
        if($input->flag(0) == '-h' || $input->flag(0) == '--help')
            $this->displayCommandHelp($input, $output, $app);

        if($input->flag(0) == '-q' || $input->flag(0) == '--quiet');
    }

    /**
     * display help for a given command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param Conso $app
     * @return void
     */
    protected function displayCommandHelp($input, $output, $app)
    {
        $name = $app->activeCommand['name'];
        $help = $app->activeCommand['help'];

        $output->writeLn("\n help for [" . $name . "] command:\n\n", "yellow");

        $output->writeLn("    php conso $name:{". implode(",", $app->activeCommand['sub']) ."} {options}\n\n");

        if(count($help) > 0)
        {
            foreach($help as $key => $value)
            {
                $output->writeLn("      [". $key ."]\n\n", 'yellow');

                foreach($value as $a => $b)
                    $output->writeLn("          " . $a . " : " . $b . "\n\n");
            }
        }
        exit;
    }
}