<?php

namespace DotfilesInstaller\Component\Instruction\Processor;

use DotfilesInstaller\Component\Instruction\InstructionInterface;
use DotfilesInstaller\Component\Instruction\LinkInstruction;
use Symfony\Component\Filesystem\Filesystem;

class LinkProcessor extends AbstractProcessor
{
    protected function getSupportedInstructions()
    {
        return [
            LinkInstruction::class,
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

    protected function getStatus(LinkInstruction $instruction)
    {
        $fs = new Filesystem();

        $link = $fs->readLink($instruction->getTarget());
        if (!$link) {
            return InstructionInterface::NOT_INSTALLED;
        }

        if ($link != $instruction->getSource()) {
            return LinkInstruction::BAD_LINK;
        }

        return InstructionInterface::OK;
    }

    protected function getInfo(LinkInstruction $instruction)
    {
        switch ($this->getStatus($instruction)) {
            case InstructionInterface::OK:
                return sprintf('Instruction %s : installed', $instruction->__toString());
            case InstructionInterface::NOT_INSTALLED:
                return sprintf('Instruction %s : not installed', $instruction->__toString());
            case LinkInstruction::BAD_LINK:
                $fs = new Filesystem();
                $link = $fs->readLink($instruction->getTarget());
                return sprintf(
                    'Instruction %s : not right target (actual : %s != configure : %s)',
                    $instruction->__toString(),
                    $link,
                    $instruction->getSource()
                );

        }
    }

    protected function install(LinkInstruction $instruction)
    {
        if ($this->getStatus($instruction) == InstructionInterface::OK) {
            return false;
        }

        $fs = new Filesystem();

        $fs->symlink(
            $instruction->getSource(),
            $instruction->getTarget()
        );

        return true;
    }
}
