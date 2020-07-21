<?php

namespace Conso;

/**
 * @author    <contact@lotfio.net>
 * @version   1.0.1
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

/**
 * This trait holds conso information.
 */
trait ConsoTrait
{
    /**
     * signature.
     *
     * @var string
     */
    protected $signature = '';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'Conso';

    /**
     * version.
     *
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * author.
     *
     * @var string
     */
    protected $author = 'Lotfio Lakehal';

    /**
     * commands path.
     *
     * @var string
     */
    protected $commandsPath = __DIR__.'/Commands';

    /**
     * commands namespace.
     *
     * @var string
     */
    protected $commandsNamespace = 'Conso\\Commands';

    /**
     * set signature method.
     *
     * @return void
     */
    public function setSignature(string $signature): void
    {
        $this->signature = $signature;
    }

    /**
     * set version method.
     *
     * @return void
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * set author.
     *
     * @return void
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * set app name.
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * set commands path.
     *
     * @return void
     */
    public function setCommandsPath(string $path): void
    {
        $this->commandsPath = $path;
    }

    /**
     * set commands namespace.
     *
     * @return void
     */
    public function setCommandsNamespace(string $namespace): void
    {
        $this->commandsNamespace = $namespace;
    }

    /**
     * set signature method.
     *
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * set app name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * get version method.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * get version method.
     *
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * get commands path.
     *
     * @return void
     */
    public function getCommandsPath(): string
    {
        return $this->commandsPath;
    }

    /**
     * get commands namespace.
     *
     * @return void
     */
    public function getCommandsNamespace(): string
    {
        return $this->commandsNamespace;
    }

    /**
     * get available commands method.
     *
     * @return array
     */
    public function &getCommands(): array
    {
        return $this->table->getCommands();
    }
}
