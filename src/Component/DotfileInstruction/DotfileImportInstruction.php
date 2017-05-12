<?php

namespace DotfilesInstaller\Component\DotfileInstruction;

class DotfileImportInstruction implements DotfileImportInstructionInterface
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
}
