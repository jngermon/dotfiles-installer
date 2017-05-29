<?php

namespace DotfilesInstaller\Command;

use DotfilesInstaller\Component\Installation;
use Mmc\Processor\Component\Processor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Translation\TranslatorInterface;

class InstallCommand extends Command
{
    protected $installation;

    protected $instructionManager;

    public function __construct(
        Installation $installation,
        Processor $instructionManager
    ) {
        parent::__construct();

        $this->installation = $installation;
        $this->instructionManager = $instructionManager;
    }

    public function configure()
    {
        $this->setName('install')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $nothingToInstall = true;

        foreach ($this->installation->getInstructionIterator() as $instruction) {
            $response = $this->instructionManager->process([
                'action' => 'install',
                'instruction' => $instruction,
            ]);

            if ($response->isSuccessed()) {
                if ($response->getOutput()) {
                    $io->text(sprintf('Instruction %s is installed', $instruction->__toString()));
                    $nothingToInstall = false;
                }
            } else {
                $io->error(sprintf('Instruction %s : %s', $instruction->__toString(), $response->getReasonPhrase()));
                $nothingToInstall = false;
            }
        }

        if ($nothingToInstall) {
            $io->success('There is nothing to install');
        }
    }
}
