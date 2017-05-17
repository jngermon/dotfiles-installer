<?php

namespace DotfilesInstaller\Component;

use DotfilesInstaller\Component\DotfileInstruction\Loader\DotfileInstructionLoaderInterface;

class InstallationFactory
{
    protected $pathConverter;

    protected $instructionLoader;

    public function __construct(
        Util\PathConverter $pathConverter,
        DotfileInstructionLoaderInterface $instructionLoader
    ) {
        $this->pathConverter = $pathConverter;
        $this->instructionLoader = $instructionLoader;
    }

    public function create($path)
    {
        return new Installation($this->pathConverter->convert($path), $this->instructionLoader);
    }
}
