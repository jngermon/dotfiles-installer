<?php

namespace DotfilesInstaller\Component\Instruction;

interface InstructionInterface
{
    const NOT_INSTALLED = 'NOT_INSTALLED';
    const MALFORMED_DOTFILE = 'MALFORMED_DOTFILE';
    const DOTFILE_NOT_FOUND = 'DOTFILE_NOT_FOUND';
    const OK = 'OK';

    public function __toString();

    public function getDotfile();
}
