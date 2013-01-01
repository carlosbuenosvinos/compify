<?php

/*
 * This file is part of Satis.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *     Nils Adermann <naderman@naderman.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CarlosIO\Compify\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

use Composer\Composer;
use Composer\Config;
use Composer\Package\Dumper\ArrayDumper;
use Composer\Package\AliasPackage;
use Composer\Package\LinkConstraint\VersionConstraint;
use Composer\Package\PackageInterface;
use Composer\Json\JsonFile;

/**
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class CrushCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('crush')
            ->setDescription('Builds a composer repository out of a json file')
            ->setDefinition(array(
                new InputArgument('file', InputArgument::OPTIONAL, 'Json file to use', './compify.json'),
                // new InputArgument('file', InputArgument::OPTIONAL, 'Json file to use', './composer.json'),
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

    /**
     * @param InputInterface  $input  The input instance
     * @param OutputInterface $output The output instance
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $verbose = $input->getOption('verbose');
        $path = $input->getArgument('vendor-path');

        // Check compify.json file
        $file = new JsonFile($input->getArgument('file'));
        if (!$file->exists()) {
            $output->writeln('<error>File compify.json not found</error>');
            return 1;
        }
        $config = $file->read();

        $originalSize = $this->calculateVendorSize($path);
        $this->crushPackages($config, $path, $output, $verbose);
        $finalSize = $this->calculateVendorSize($path);

        $output->writeln('You have save <info>' . ($originalSize - $finalSize) . ' bytes</info>');
    }

    private function crushPackages($config, $path, OutputInterface $output, $verbose)
    {
        $packageRules = $config['packages-rules'];
        foreach ($packageRules as $package => $rules) {
            foreach ($rules as $rule) {
                $cmd = 'rm -rf ' . $path . '/' . $package . '/' . $rule;
                $process = new Process($cmd);
                $process->run();
                if (!$process->isSuccessful()) {
                    throw new \RuntimeException($process->getErrorOutput());
                }
            }
        }
    }

    private function calculateVendorSize($path)
    {
        $cmd = 'du -h -s ' . $path;
        $process = new Process($cmd);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $output = explode("\t", $process->getOutput());
        return (int) $output[0];
    }
}