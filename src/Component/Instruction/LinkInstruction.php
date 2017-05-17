<?php

namespace DotfilesInstaller\Component\Instruction;

class LinkInstruction implements LinkInstructionInterface
{
    protected $source;

    protected $target;

    public function __construct(
        $source,
        $target
    ) {
        $this->source = $source;
        $this->target = $target;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getStatus()
    {
        return Instruction::NOT_INSTALLED;
    }
}
