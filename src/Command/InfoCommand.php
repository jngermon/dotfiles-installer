<?php

namespace DotfilesInstaller\Command;

use DotfilesInstaller\Component\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InfoCommand extends Command
{
    protected $config;

    public function __construct(
        Config $config
    ) {
        parent::__construct();

        $this->config = $config;
    }

    public function configure()
    {
        $this->setName('info')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello world');
        $output->writeln($this->config->getPath());
    }
}

