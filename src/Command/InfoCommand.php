<?php

namespace DotfilesInstaller\Command;

use DotfilesInstaller\Component\Installation;
use DotfilesInstaller\Component\Instruction\InstructionInterface;
use Mmc\Processor\Component\Processor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Translation\TranslatorInterface;

class InfoCommand extends Command
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
        $this->setName('info')
            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $everythingOk = true;
        foreach ($this->installation->getInstructionIterator() as $instruction) {
            $response = $this->instructionManager->process([
                'action' => 'status',
                'instruction' => $instruction,
            ]);

            if ($response->isSuccessed()) {
                if ($response->getOutput() != InstructionInterface::OK) {
                    $everythingOk = false;
                }
                if ($response->getOutput() != InstructionInterface::OK || $output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                    $response = $this->instructionManager->process([
                        'action' => 'info',
                        'instruction' => $instruction,
                    ]);

                    if ($response->isSuccessed()) {
                        $io->error($response->getOutput());
                    }
                }
            } else {
                $io->error($response->getReasonPhrase());
                $everythingOk = false;
            }
        }

        if ($everythingOk) {
            $io->success('Everything is OK');
        }
    }
}
