<?php

namespace DotfilesInstaller\Component;

use DotfilesInstaller\Component\Instruction\Loader\InstructionLoaderInterface;

class InstallationFactory
{
    protected $pathConverter;

    protected $instructionLoader;

    public function __construct(
        Util\PathConverter $pathConverter,
        InstructionLoaderInterface $instructionLoader
    ) {
        $this->pathConverter = $pathConverter;
        $this->instructionLoader = $instructionLoader;
    }

    public function create($path)
    {
        return new Installation($this->pathConverter->convert($path), $this->instructionLoader);
    }
}
