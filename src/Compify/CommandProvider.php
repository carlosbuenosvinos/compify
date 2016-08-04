<?php

namespace CarlosBuenosvinos;

use CarlosBuenosvinos\Compify\Command\CrushCommand;
use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;

class CommandProvider implements CommandProviderCapability
{
    public function getCommands()
    {
        return array(new CrushCommand());
    }
}