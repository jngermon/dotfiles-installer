<?php

namespace DotfilesInstaller\Component\Instruction;

class LinkInstruction extends Instruction implements LinkInstructionInterface
{
    const BAD_LINK = 'BAD_LINK';

    protected $source;

    protected $target;

    public function __construct(
        $root,
        $source,
        $target
    ) {
        parent::__construct($root);

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
        return sprintf('Link %s%s to %s', $this->root, $this->source, $this->target);
    }
}
