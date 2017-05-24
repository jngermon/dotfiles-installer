<?php

namespace DotfilesInstaller\Component\Instruction\Loader;

use DotfilesInstaller\Component\Instruction\Configuration;
use DotfilesInstaller\Component\Instruction\InstructionFactory;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class InstructionLoader implements InstructionLoaderInterface
{
    protected $instructionFactory;

    protected $loadedPaths;

    public function __construct(
        InstructionFactory $instructionFactory
    ) {
        $this->instructionFactory = $instructionFactory;
        $this->loadedPaths = [];
    }

    public function load($path, $force = false)
    {
        $path = realpath($path);

        if (!$path || !file_exists($path)) {
            throw new Exception\FileNotFoundException(sprintf('Unable to find the file "%s"', $path));
        }

        if (!$force && in_array($path, $this->loadedPaths)) {
            throw new Exception\AlreadyLoadedPathException(sprintf('This file has already been loaded "%s"', $path));
        }


        if (!$force) {
            $this->loadedPaths[] = $path;
        }

        $root = dirname($path);

        try {
            $config = Yaml::parse(file_get_contents($path));

            $processor = new Processor();

            $configuration = new Configuration();

            $config = $processor->processConfiguration($configuration, $config);

            $instructions = [];

            foreach ($config['remotes'] as $remote) {
                $instructions[] = $this->instructionFactory->createRemote($remote['name'], $remote['url']);
            }

            foreach ($config['links'] as $link) {
                $instructions[] = $this->instructionFactory->createLink($root, $link['source'], $link['target']);
            }

            foreach ($config['imports'] as $import) {
                $instructions[] = $this->instructionFactory->createImport($root, $import['name'], $import['path']);
            }

            return $instructions;
        } catch (ParseException $e) {
            throw new Exception\ParseException(sprintf("Unable to parse the YAML string: %s", $e->getMessage()), $e->getCode(), $e);
        }
    }
}
