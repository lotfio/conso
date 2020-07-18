<?php

namespace Tests\Unit\Mocks;

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

use Conso\Command as BaseCommand;
use Conso\Conso;
use Conso\Contracts\CommandInterface;
use Conso\Contracts\InputInterface;
use Conso\Contracts\OutputInterface;

class Make extends BaseCommand implements CommandInterface
{
    /**
     * sub commands.
     *
     * @var array
     */
    protected $sub = [
    ];

    /**
     * flags.
     *
     * @var array
     */
    protected $flags = [
    ];

    /**
     * command help.
     *
     * @var string
     */
    protected $help = [
    ];

    /**
     * command description.
     *
     * @var string
     */
    protected $description = 'This is Make command description.';

    /**
     * execute method.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output, Conso $app): void
    {
        echo 'from make class command';
    }
}
