<?php

namespace DotfilesInstaller\Component;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Config\Definition\Dumper\YamlReferenceDumper;

class Installation
{
    protected $path;

    protected $fs;

    public function __construct(
        $path,
        Util\PathConverter $pathConverter
    ) {
        $this->path = $pathConverter->convert($path);
        $this->fs = new Filesystem();
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
}
