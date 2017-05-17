<?php

namespace DotfilesInstaller\Component\Instruction;

interface ImportInstructionInterface extends InstructionInterface
{
    public function getName();

    public function getPath();
}
