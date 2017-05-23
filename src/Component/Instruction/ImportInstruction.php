<?php

namespace DotfilesInstaller\Component\Instruction;

class ImportInstruction extends Instruction implements ImportInstructionInterface
{
    protected $name;

    protected $path;

    public function __construct(
        $root,
        $name,
        $path
    ) {
        parent::__construct($root);

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
        return sprintf('Import %s to %s%s', $this->path, $this->root, $this->name);
    }
}
