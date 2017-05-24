<?php

namespace DotfilesInstaller\Component;

use DotfilesInstaller\Component\Instruction\Configuration;
use DotfilesInstaller\Component\Instruction\ImportInstruction;
use DotfilesInstaller\Component\Instruction\InstructionIterator;
use DotfilesInstaller\Component\Instruction\Loader\InstructionLoaderInterface;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;
use Symfony\Component\Filesystem\Filesystem;

class Installation
{
    protected $path;

    protected $fs;

    protected $instructionLoader;

    protected $instructionIterator;

    public function __construct(
        $path,
        InstructionLoaderInterface $instructionLoader
    ) {
        $this->path = $path;
        $this->fs = new Filesystem();
        $this->instructionLoader = $instructionLoader;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function isInit()
    {
        return $this->fs->exists($this->path);
    }

    public function init()
    {
        if (!$this->isInit()) {
            $configuration = new Configuration();

            $yamlDumper = new YamlReferenceDumper();

            $this->fs->dumpFile($this->path, $yamlDumper->dump($configuration));
        }
    }

    public function getInstructionIterator()
    {
        if (!$this->instructionIterator) {
            $this->instructionIterator = new InstructionIterator(new ImportInstruction('main', $this->getPath()), $this->instructionLoader);
        }

        return $this->instructionIterator;
    }
}
