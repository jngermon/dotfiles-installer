<?php

namespace DotfilesInstaller\Component\Instruction;

use DotfilesInstaller\Component\Util\PathConverter;

class InstructionFactory
{
    protected $pathConverter;

    protected $repositoriesPath;

    public function __construct(
        PathConverter $pathConverter,
        $repositoriesPath
    ) {
        $this->pathConverter = $pathConverter;
        $this->repositoriesPath = $repositoriesPath;
    }

    public function createLink($root, $source, $target)
    {
        $source = $this->pathConverter->convert($source, $root);

        $target = $this->pathConverter->convert($target);

        return new LinkInstruction($source, $target);
    }

    public function createImport($root, $name, $path)
    {
        $path = $this->pathConverter->convert($path, $root);

        return new ImportInstruction($name, $path);
    }

    public function createRemote($name, $url)
    {
        $path = $this->pathConverter->convert($this->repositoriesPath.DIRECTORY_SEPARATOR.$name);

        return new RemoteInstruction($name, $url, $path);
    }
}
