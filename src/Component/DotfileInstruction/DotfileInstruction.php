<?php

namespace DotfilesInstaller\Component\DotfileInstruction;

class DotfileInstruction
{
    protected $remotes;

    protected $imports;

    protected $links;

    public function __construct()
    {
        $this->remotes = [];
        $this->imports = [];
        $this->links = [];
    }

    public function addRemote(DotfileRemoteInstructionInterface $remote)
    {
        $this->remotes[] = $remote;
    }

    public function addImport(DotfileImportInstructionInterface $import)
    {
        $this->imports[] = $import;
    }

    public function addLink(DotfileLinkInstructionInterface $link)
    {
        $this->links[] = $link;
    }

    public function getRemotes()
    {
        return $this->remotes;
    }

    public function getImports()
    {
        return $this->imports;
    }

    public function getLinks()
    {
        return $this->links;
    }
}
