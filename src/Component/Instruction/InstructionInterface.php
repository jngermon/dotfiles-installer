<?php

namespace DotfilesInstaller\Component\Instruction;

interface InstructionInterface
{
    const NOT_INSTALLED = 'NOT_INSTALLED';
    const OK = 'OK';

    public function __toString();
}
