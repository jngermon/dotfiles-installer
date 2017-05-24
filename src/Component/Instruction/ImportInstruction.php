<?php

namespace DotfilesInstaller\Component\Instruction;

class ImportInstruction implements ImportInstructionInterface
{
    protected $path;

    public function __construct(
        $path
    ) {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function __toString()
    {
        return sprintf('Import %s', $this->path);
    }

    public function getDotfile()
    {
        return $this->path;
    }
}
