<?php

/*
 * This file is part of Compify.
 *
 * (c) Carlos Buenosvinos <hi@carlos.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CarlosIO\Compify\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Carlos Buenosvinos <hi@carlos.io>
 */
class SelfUpdateCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('self-update')
            ->setDescription('Update compify.phar to the latest version.')
            ->setHelp(<<<EOT
The <info>self-update</info> command replace your compify.phar
by the latest version from github.com.

<info>php compify.phar self-update</info>

EOT
        )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $remoteFilename = "https://raw.github.com/carlosbuenosvinos/compify/master/compify.phar";
        $localFilename  = $_SERVER['argv'][0];
        $tempFilename   = basename($localFilename, '.phar').'-temp.phar';

        try {
            copy($remoteFilename, $tempFilename);
            chmod($tempFilename, 0777 & ~umask());

            // test the phar validity
            $phar = new \Phar($tempFilename);
            // free the variable to unlock the file
            unset($phar);
            rename($tempFilename, $localFilename);
        } catch (\Exception $e) {
            if (!$e instanceof \UnexpectedValueException && !$e instanceof \PharException) {
                throw $e;
            }
            unlink($tempFilename);
            $output->writeln('<error>The download is corrupt ('.$e->getMessage().').</error>');
            $output->writeln('<error>Please re-run the self-update command to try again.</error>');
        }

        $output->writeln("<info>compify updated.</info>");
    }
}