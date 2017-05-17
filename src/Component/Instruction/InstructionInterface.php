<?php

namespace DotfilesInstaller\Component\Instruction;

interface InstructionInterface
{
    const NOT_INSTALLED = 'NOT_INSTALLED';
    const INSTALLED = 'INSTALLED';

    public function getStatus();
}
