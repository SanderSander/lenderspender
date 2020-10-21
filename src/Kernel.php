<?php

declare(strict_types=1);

namespace Acme;

use Acme\Commands\SimulateCommand;
use Symfony\Component\Console\Application;

class Kernel
{
    public function run(): void
    {
        $application = new Application("Heartbreak simulation");
        $application->add(new SimulateCommand());
        $application->run();
    }
}
