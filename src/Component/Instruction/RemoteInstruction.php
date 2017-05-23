<?php

namespace DotfilesInstaller\Component\Instruction;

class RemoteInstruction extends Instruction implements RemoteInstructionInterface
{
    protected $name;

    protected $url;

    public function __construct(
        $root,
        $name,
        $url
    ) {
        parent::__construct($root);

        $this->name = $name;
        $this->url = $url;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function __toString()
    {
        return sprintf('Remote %s to %s%s', $this->url, $this->root, $this->name);
    }
}
