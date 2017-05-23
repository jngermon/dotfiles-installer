<?php

namespace DotfilesInstaller\Component\Instruction;

class Instruction implements InstructionInterface
{
    protected $root;

    public function __construct(
        $root
    ) {
        $this->root = $root;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function __toString()
    {
        return '';
    }
}
