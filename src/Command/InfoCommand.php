<?php

namespace DotfilesInstaller\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InfoCommand extends Command
{
    public function configure()
    {
        $this->setName('info')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello wolrd');
    }
}

