<?php

namespace DotfilesInstaller\Component\Instruction\Processor;

use DotfilesInstaller\Component\Instruction\ImportInstruction;
use Symfony\Component\Filesystem\Filesystem;

class ImportProcessor extends AbstractProcessor
{
    protected function getSupportedInstructions()
    {
        return [
            ImportInstruction::class,
        ];
    }

    protected function getSupportedActions()
    {
        return [
            'status',
            'info',
            'install',
        ];
    }

    protected function doProcess($request)
    {
        $instruction = $request['instruction'];

        switch ($request['action']) {
            case 'status':
                return $this->getStatus($instruction);
            case 'info':
                return $this->getInfo($instruction);
            case 'install':
                return $this->install($instruction);
        }
    }

    protected function getStatus(ImportInstruction $instruction)
    {
        $fs = new Filesystem();

        if (!$fs->exists($instruction->getPath())) {
            return ImportInstruction::NOT_INSTALLED;
        }

        return ImportInstruction::OK;
    }

    protected function getInfo(ImportInstruction $instruction)
    {
        switch ($this->getStatus($instruction)) {
            case ImportInstruction::OK:
                return sprintf('Instruction %s : installed', $instruction->__toString());
            case ImportInstruction::NOT_INSTALLED:
                return sprintf('Instruction %s : not installed', $instruction->__toString());
        }
    }

    protected function install(ImportInstruction $instruction)
    {
        return false;
    }
}
