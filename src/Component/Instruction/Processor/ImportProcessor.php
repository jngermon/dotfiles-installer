<?php

namespace DotfilesInstaller\Component\Instruction\Processor;

use DotfilesInstaller\Component\Instruction\ImportInstruction;
use DotfilesInstaller\Component\Instruction\Loader\Exception as LoaderException;
use DotfilesInstaller\Component\Instruction\Loader\InstructionLoaderInterface;

class ImportProcessor extends AbstractProcessor
{
    protected $loader;

    public function __construct(
        InstructionLoaderInterface $loader
    ) {
        $this->loader = $loader;
    }

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
        try {
            $instructions = $this->loader->load($instruction->getDotfile(), true);
        } catch (LoaderException\FileNotFoundException $e) {
            return ImportInstruction::DOTFILE_NOT_FOUND;
        } catch (LoaderException\ParseException $e) {
            return ImportInstruction::MALFORMED_DOTFILE;
        }

        return ImportInstruction::OK;
    }

    protected function getInfo(ImportInstruction $instruction)
    {
        switch ($this->getStatus($instruction)) {
            case ImportInstruction::OK:
                return sprintf('Instruction %s : installed', $instruction->__toString());
            case ImportInstruction::DOTFILE_NOT_FOUND:
                return sprintf('Instruction %s : dotfile is not found', $instruction->getDotfile());
            case ImportInstruction::MALFORMED_DOTFILE:
                return sprintf('Instruction %s : dotfile is malformed', $instruction->getDotfile());
        }
    }

    protected function install(ImportInstruction $instruction)
    {
        return false;
    }
}
