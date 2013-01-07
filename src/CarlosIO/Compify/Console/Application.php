<?php

/*
 * This file is part of Satis.
 *
 * (c) Carlos Buenosvinos <hi@carlos.io>
 *     Nils Adermann <naderman@naderman.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CarlosIO\Compify\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\IO\ConsoleIO;
use Composer\Factory;
use Composer\Util\ErrorHandler;
use Composer\Json\JsonFile;
use Composer\Repository;

use CarlosIO\Compify\Command;
use CarlosIO\Compify\Compify;

/**
 * @author Carlos Buenosvinos <hi@carlos.io>
 */
class Application extends BaseApplication
{
    protected $io;
    protected $composer;

    public function __construct()
    {
        parent::__construct('Compify', Compify::VERSION);
        ErrorHandler::register();
    }

    /**
     * {@inheritDoc}
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->registerCommands();
        $this->io = new ConsoleIO($input, $output, $this->getHelperSet());

        return parent::doRun($input, $output);
    }

    /**
     * @return Composer
     */
    public function getComposer($required = true, $config = null)
    {
        if (null === $this->composer) {
            try {
                $this->composer = Factory::create($this->io, $config);
            } catch (\InvalidArgumentException $e) {
                $this->io->write($e->getMessage());
                exit(1);
            }
        }

        return $this->composer;
    }

    /**
     * Initializes all the composer commands
     */
    protected function registerCommands()
    {
        $this->add(new Command\CrushCommand());
    }
}