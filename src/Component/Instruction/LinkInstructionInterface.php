<?php

namespace DotfilesInstaller\Component\Instruction;

interface LinkInstructionInterface extends InstructionInterface
{
    public function getSource();

    public function getTarget();
}
