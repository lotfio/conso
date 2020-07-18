<?php

/**
 *
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   1.0.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

$conso->command('--version',  function($inp, $out, $app){

    $out->writeLn("\n " . $app->getName() . " version " . $app->getVersion() . "\n", "yellow");

})->alias(['-v']);

$conso->command('--help',  function($inp, $out, $app){

        $out->writeLn("\nUsage: \n\n", 'yellow');
        $out->writeLn("    command:subcommand [options] [-flags]\n\n");

        $out->writeLn("Special flags: \n\n", 'yellow');

        $flags = $inp->reservedFlags();
        $out->writeLn("    " . $flags[0] . "   ",   'green');
        $out->writeLn("    " . $flags[1] . "   \n", 'green');
        $out->writeLn("    " . $flags[2] . "   ",   'green');
        $out->writeLn("    " . $flags[3] . "   \n", 'green');
        $out->writeLn("    " . $flags[4] . "   ",   'green');
        $out->writeLn("    " . $flags[5] . "   \n", 'green');
        $out->writeLn("    " . $flags[6] . "   ",   'green');
        $out->writeLn("    " . $flags[7] . "   \n", 'green');
        $out->writeLn("    " . $flags[8] . "   ",   'green');
        $out->writeLn(         $flags[9] . "   \n", 'green');
        $out->writeLn("    " . $flags[10] . "   ",   'green');
        $out->writeLn("    " . $flags[11] . "   \n", 'green');

        $out->writeLn("\nHelp: \n\n", 'yellow');
        $out->writeLn(" The help special flag displays help for a given command: \n\n");
        $out->writeLn(" To display application version, please use the -v or --version special flags.\n");
        $out->writeLn(" To display the list of available commands, please use the -c or --commands special flags.\n");
        $out->writeLn(" To silent warning, please use the -q or --quiet special flags.\n");
        $out->writeLn(" To disable ansi, please use the --no-ansi special flag.\n");

})->alias(['-h']);

$conso->command('--commands',  function($inp, $out, $app){
    // remove special commands
    $commands = array_filter($app->getCommands(), function($elem){
        if(strpos($elem['name'], '--') === FALSE) return $elem;
    });

    if(count($commands) > 0)
    {
        $out->writeLn("\nAvailable Commands: \n\n", 'yellow');

        $max = max(array_map(function($elem){ return count($elem);}, $commands));

        foreach($commands as $command)
        {
            $out->writeLn("  ". $command['name'] .  str_repeat(' ', ($max - strlen($command['name'])) + 4 ), 'green');
            $out->writeLn($command['description'] .  "\n");
        }

        $out->writeLn("\n");
    }

})->alias(['-c']);

$conso->command('--no-ansi', function($inp, $out, $app){
    $out->disableAnsi(); // disable ansi
    $cm  = explode(DIRECTORY_SEPARATOR, getcwd());
    $cmd = ' php ' . $cm[count($cm) - 1];
    passthru($cmd);
});

$conso->command('command', 'Conso\\Commands\\Command');