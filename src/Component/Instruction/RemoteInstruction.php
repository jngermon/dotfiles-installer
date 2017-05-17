<?php

namespace DotfilesInstaller\Component\Instruction;

class RemoteInstruction implements RemoteInstructionInterface
{
    protected $name;

    protected $url;

    public function __construct(
        $name,
        $url
    ) {
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

    public function getStatus()
    {
        return Instruction::NOT_INSTALLED;
    }
}
