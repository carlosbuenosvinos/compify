<?php

/*
 * This file is part of Compify.
 *
 * (c) Carlos Buenosvinos <carlos.buenosvinos@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CarlosBuenosvinos\Compify\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;
use Composer\Composer;
use Composer\Package\AliasPackage;

/**
 * @author Carlos Buenosvinos <carlos.buenosvinos@gmail.com>
 */
class CrushCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('crush')
            ->setDescription('Removes unnecesary files for each composer dependency')
            ->setDefinition(array(
                new InputArgument('vendor-path', InputArgument::OPTIONAL, 'Composer vendor path', './vendor')
        ))
            ->setHelp(<<<EOT
The <info>crush</info> command removes all the
unnecessary files for each composer
package in order to save disk usage
and bandwidth.
EOT
        )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);

        $verbose = $input->getOption('verbose');
        $path = $input->getArgument('vendor-path');

        $composer = $this->getApplication()->getComposer();
        $output->writeln('<info>Crushing vendors</info> <comment>(by Carlos Buenosvinos)</comment>');
        $originalSize = $this->calculateVendorSize($path);
        $this->crushPackages($composer, $path, $output, $verbose);
        $finalSize = $this->calculateVendorSize($path);
        $output->writeln('Vendor size before crushing: <info>' . $originalSize . '</info>');
        $output->writeln('Vendor size after crushing: <info>' . $finalSize . '</info>');
    }

    private function crushPackages($composer, $path, OutputInterface $output, $verbose = false)
    {
        $config = \CarlosBuenosvinos\Compify\Compify::$rules;
        $packageRules = $config['packages-rules'];
        $genericRules = $config['generic-rules'];

        $packages = $this->selectPackages($composer, $output, $verbose);
        foreach ($packages as $package) {
            $prettyName = $package->getPrettyName();
            if ($verbose) {
                $output->writeln('<comment>Processing package ' . $prettyName . '</comment>');
            }

            $rules = $genericRules;
            if (isset($packageRules[$prettyName])) {
                $rules = array_merge($rules, $packageRules[$prettyName]);
            }

            foreach ($rules as $rule) {
                $cmd = 'rm -rf ' . $path . '/' . $prettyName . '/' . $rule;
                if ($verbose) {
                    $output->writeln($cmd);
                }
                $process = new Process($cmd);
                $process->setTimeout(600);
                $process->run();
                if (!$process->isSuccessful()) {
                    throw new \RuntimeException($process->getErrorOutput());
                }
            }
        }

        // Cleaning .git and .svn
        $cleanCommands = array();
        $cleanCommands[] = 'rm `find "' . $path . '" -name \'.git\'` -rf';
        $cleanCommands[] = 'rm `find "' . $path . '" -name \'.svn\'` -rf';
        foreach ($cleanCommands as $cmd) {
            if ($verbose) {
                $output->writeln('<comment>' . $cmd . '</comment>');
            }
            $process = new Process($cmd);
            $process->setTimeout(600);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }
        }
    }

    private function calculateVendorSize($path)
    {
        $cmd = 'du -sh ' . $path;
        $process = new Process($cmd);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $output = explode("\t", $process->getOutput());
        return trim($output[0]);
    }


    private function selectPackages(Composer $composer)
    {
        $selected = array();
        foreach ($composer->getRepositoryManager()->getLocalRepositories() as $repository) {
            foreach ($repository->getPackages() as $package) {
                // skip aliases
                if ($package instanceof AliasPackage) {
                    continue;
                }

                $selected[] = $package;
            }
        }
        return $selected;
    }
}