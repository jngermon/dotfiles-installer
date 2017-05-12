<?php

namespace DotfilesInstaller\Command;

use DotfilesInstaller\Component\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitCommand extends Command
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
        $this->setName('init')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if ($this->config->isInit()) {
            $io->note('The dotfile installer is already init.');
            $io->note(sprintf('Edit and complete the main "dotfiles.yml" (%s)', $this->config->getPath()));
            return;
        }

        $this->config->init();

        $io->success(sprintf('Your main "dotfiles.yml" (%s) is created.', $this->config->getPath()));
    }
}
