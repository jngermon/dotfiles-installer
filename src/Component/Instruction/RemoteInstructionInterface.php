<?php

namespace DotfilesInstaller\Component\Instruction;

interface RemoteInstructionInterface extends InstructionInterface
{
    public function getName();

    public function getUrl();

    public function getPath();
}
