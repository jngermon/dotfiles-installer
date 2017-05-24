<?php

namespace DotfilesInstaller\Component\Instruction;

class RemoteInstruction implements RemoteInstructionInterface
{
    const NO_ORIGIN_REMOTE = 'NO_ORIGIN_REMOTE';
    const BAD_ORIGIN_REMOTE = 'BAD_ORIGIN_REMOTE';
    const HAS_CHANGES = 'HAS_CHANGES';
    const IS_NOT_UP_TO_DATE = 'IS_NOT_UP_TO_DATE';

    protected $name;

    protected $url;

    protected $path;

    public function __construct(
        $name,
        $url,
        $path
    ) {
        $this->name = $name;
        $this->url = $url;
        $this->path = $path;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function __toString()
    {
        return sprintf('Remote %s, %s to %s', $this->name, $this->url, $this->path);
    }
}
