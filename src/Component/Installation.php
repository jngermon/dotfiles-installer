<?php

namespace DotfilesInstaller\Component;

use DotfilesInstaller\Component\DotfileInstruction\Configuration;
use DotfilesInstaller\Component\DotfileInstruction\Loader\DotfileInstructionLoaderInterface;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;
use Symfony\Component\Filesystem\Filesystem;

class Installation
{
    protected $path;

    protected $fs;

    protected $instructionLoader;

    protected $instructions;

    public function __construct(
        $path,
        DotfileInstructionLoaderInterface $instructionLoader
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

    public function getInstructions()
    {
        if (!$this->instructions) {
            $this->instructions = $this->instructionLoader->load($this->getPath());
        }

        return $this->instructions;
    }
}
