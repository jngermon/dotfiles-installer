<?php

namespace DotfilesInstaller\Component\Instruction\Processor;

use DotfilesInstaller\Component\Instruction\InstructionInterface;
use DotfilesInstaller\Component\Instruction\RemoteInstruction;
use GitWrapper\GitWrapper;

class RemoteProcessor extends AbstractProcessor
{
    protected $statuses = [];

    protected function getSupportedInstructions()
    {
        return [
            RemoteInstruction::class,
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

    protected function getRepository(RemoteInstruction $instruction)
    {
        $wrapper = new GitWrapper();

        $git = $wrapper->workingCopy($instruction->getPath());

        return $git;
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

    protected function getStatus(RemoteInstruction $instruction)
    {
        if (!isset($this->statuses[$instruction->__toString()])) {
            $this->statuses[$instruction->__toString()] = $this->_getStatus($instruction);
        }

        return $this->statuses[$instruction->__toString()];
    }

    protected function _getStatus(RemoteInstruction $instruction)
    {
        $repo = $this->getRepository($instruction);

        if (!$repo->isCloned()) {
            return InstructionInterface::NOT_INSTALLED;
        }

        if (!$repo->hasRemote('origin')) {
            return RemoteInstruction::NO_ORIGIN_REMOTE;
        }

        if ($repo->getRemote('origin')['fetch'] != $instruction->getUrl()) {
            return RemoteInstruction::BAD_ORIGIN_REMOTE;
        }

        if ($repo->hasChanges()) {
            return RemoteInstruction::HAS_CHANGES;
        }

        $repo->fetch();

        if (!$repo->isUpToDate()) {
            return RemoteInstruction::IS_NOT_UP_TO_DATE;
        }

        return InstructionInterface::OK;
    }

    protected function getInfo(RemoteInstruction $instruction)
    {
        switch ($this->getStatus($instruction)) {
            case InstructionInterface::OK:
                return sprintf('Instruction %s : installed and up to date', $instruction->__toString());
            case InstructionInterface::NOT_INSTALLED:
                return sprintf('Instruction %s : not installed', $instruction->__toString());
            case RemoteInstruction::NO_ORIGIN_REMOTE:
                return sprintf('Instruction %s : hasn\'t got origin remote', $instruction->__toString());
            case RemoteInstruction::BAD_ORIGIN_REMOTE:
                $repo = $this->getRepository($instruction);
                return sprintf(
                    'Instruction %s : not right origin remote (actual : %s != configure : %s)',
                    $instruction->__toString(),
                    $repo->getRemote('origin')['fetch'],
                    $instruction->getUrl()
                );
            case RemoteInstruction::HAS_CHANGES:
                return sprintf('Instruction %s : has got local changes', $instruction->__toString());
            case RemoteInstruction::IS_NOT_UP_TO_DATE:
                return sprintf('Instruction %s : is not up to date', $instruction->__toString());
        }
    }

    protected function install(RemoteInstruction $instruction)
    {
        $repo = $this->getRepository($instruction);

        if ($repo->isCloned()) {
            return false;
        }

        $repo->clone($instruction->getUrl());

        return true;
    }

    protected function pull(RemoteInstruction $instruction)
    {
        $repo = $this->getRepository($instruction);

        if ($repo->isCloned()) {
            return false;
        }

        $repo->pull();

        return true;
    }
}
