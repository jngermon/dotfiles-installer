<?php

namespace DotfilesInstaller\Component\DotfileInstruction;

class DotfileLinkInstruction implements DotfileLinkInstructionInterface
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
}
