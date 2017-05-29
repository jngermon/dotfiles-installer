<?php

namespace DotfilesInstaller\Component;

use DotfilesInstaller\Component\Instruction\Configuration;
use DotfilesInstaller\Component\Instruction\ImportInstruction;
use DotfilesInstaller\Component\Instruction\InstructionIterator;
use DotfilesInstaller\Component\Instruction\Loader\InstructionLoaderInterface;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

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

    public function init($defaultConfig = [])
    {
        if (!$this->isInit()) {
            $configuration = new Configuration();
            $processor = new Processor();
            $yamlDumper = new YamlReferenceDumper();

            $content = $yamlDumper->dump($configuration);

            $content = preg_replace('/\n/', "\n#", $content);

            $default = Yaml::dump($processor->processConfiguration($configuration, [$defaultConfig]));

            $default = preg_replace('/(\n)/', "\n    ", $default);

            $content = preg_replace('/^dotfiles:/', "dotfiles:\n    ".$default, $content);

            $content = preg_replace('/\n#$/', '', $content);

            $this->fs->dumpFile($this->path, $content);
        }
    }

    public function getInstructionIterator()
    {
        if (!$this->instructionIterator) {
            $this->instructionIterator = new InstructionIterator(new ImportInstruction($this->getPath()), $this->instructionLoader);
        }

        return $this->instructionIterator;
    }
}
