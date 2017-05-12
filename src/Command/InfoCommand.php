<?php

namespace DotfilesInstaller\Command;

use DotfilesInstaller\Component\Config;
use DotfilesInstaller\Component\DotfileInstruction\Loader\DotfileInstructionLoaderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InfoCommand extends Command
{
    protected $config;

    protected $instructionLoader;

    public function __construct(
        Config $config,
        DotfileInstructionLoaderInterface $instructionLoader
    ) {
        parent::__construct();

        $this->config = $config;
        $this->instructionLoader = $instructionLoader;
    }

    public function configure()
    {
        $this->setName('info')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if (!$this->config->isInit()) {
            $io->warning(sprintf('Unable to find the main "dotfiles.yml" (%s)', $this->config->getPath()));
            $io->note('use "dotfilesInstaller init"');

            return;
        }
    }
}
