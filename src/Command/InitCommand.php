<?php

namespace DotfilesInstaller\Command;

use DotfilesInstaller\Component\Installation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitCommand extends Command
{
    protected $installation;

    public function __construct(
        Installation $installation
    ) {
        parent::__construct();

        $this->installation = $installation;
    }

    public function configure()
    {
        $this->setName('init')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if ($this->installation->isInit()) {
            $io->note('The dotfile installer is already init.');
            $io->note(sprintf('Edit and complete the main "dotfiles.yml" (%s)', $this->installation->getPath()));

            return;
        }

        $this->installation->init();

        $io->success(sprintf('Your main "dotfiles.yml" (%s) is created.', $this->installation->getPath()));
    }
}
