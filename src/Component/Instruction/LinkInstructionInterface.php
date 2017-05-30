<?php

namespace DotfilesInstaller\Component\Instruction;

interface LinkInstructionInterface extends InstructionInterface
{
    const TARGET_NOT_FREE = 'TARGET_NOT_FREE';
    const BAD_LINK = 'BAD_LINK';

    public function getSource();

    public function getTarget();
}
