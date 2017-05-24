<?php

namespace DotfilesInstaller\Component\Instruction;

class LinkInstruction implements LinkInstructionInterface
{
    const BAD_LINK = 'BAD_LINK';

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

    public function __toString()
    {
        return sprintf('Link %s to %s', $this->source, $this->target);
    }
}
