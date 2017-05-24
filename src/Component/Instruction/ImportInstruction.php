<?php

namespace DotfilesInstaller\Component\Instruction;

class ImportInstruction implements ImportInstructionInterface
{
    protected $name;

    protected $path;

    public function __construct(
        $name,
        $path
    ) {
        $this->name = $name;
        $this->path = $path;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function __toString()
    {
        return sprintf('Import %s', $this->path);
    }
}
