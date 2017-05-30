<?php

namespace DotfilesInstaller\Component\Instruction\Processor;

use DotfilesInstaller\Component\Instruction\InstructionInterface;
use DotfilesInstaller\Component\Instruction\Loader\Exception as LoaderException;
use DotfilesInstaller\Component\Instruction\Loader\InstructionLoaderInterface;
use DotfilesInstaller\Component\Instruction\RemoteInstruction;
use GitWrapper\GitWrapper;
use Symfony\Component\Filesystem\Filesystem;

class RemoteProcessor extends AbstractProcessor
{
    protected $statuses = [];

    protected $loader;

    public function __construct(
        InstructionLoaderInterface $loader
    ) {
        $this->loader = $loader;
    }

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
            'installStatus',
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
            case 'installStatus':
                return $this->installStatus($instruction);
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

        try {
            $instructions = $this->loader->load($instruction->getDotfile(), true);
        } catch (LoaderException\FileNotFoundException $e) {
            return RemoteInstruction::DOTFILE_NOT_FOUND;
        } catch (LoaderException\ParseException $e) {
            return RemoteInstruction::MALFORMED_DOTFILE;
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
            case RemoteInstruction::DOTFILE_NOT_FOUND:
                return sprintf('Instruction %s : dotfile is not found', $instruction->getDotfile());
            case RemoteInstruction::MALFORMED_DOTFILE:
                return sprintf('Instruction %s : dotfile is malformed', $instruction->getDotfile());
        }
    }

    protected function installStatus(RemoteInstruction $instruction)
    {
        $status = $this->getStatus($instruction);

        switch ($status) {
            case InstructionInterface::NOT_INSTALLED:
            case RemoteInstruction::NO_ORIGIN_REMOTE:
            case RemoteInstruction::BAD_ORIGIN_REMOTE:
                return $status;
            default:
                return InstructionInterface::OK;
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
