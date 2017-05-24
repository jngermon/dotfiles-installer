<?php

namespace DotfilesInstaller\Component\Instruction;

class RemoteInstruction implements RemoteInstructionInterface
{
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

    public function getDotfile()
    {
        return $this->path.DIRECTORY_SEPARATOR.'dotfiles.yml';
    }
}
