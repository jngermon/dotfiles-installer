<?php

namespace DotfilesInstaller\Component\Instruction\Loader;

use DotfilesInstaller\Component\Instruction\Configuration;
use DotfilesInstaller\Component\Instruction\ImportInstruction;
use DotfilesInstaller\Component\Instruction\LinkInstruction;
use DotfilesInstaller\Component\Instruction\RemoteInstruction;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class InstructionLoader implements InstructionLoaderInterface
{
    public function load($path)
    {
        if (!file_exists($path)) {
            throw new Exception\FileNotFoundException(sprintf('Unable to find the file "%s"', $path));
        }

        try {
            $config = Yaml::parse(file_get_contents($path));

            $processor = new Processor();

            $configuration = new Configuration();

            $config = $processor->processConfiguration($configuration, $config);

            $instructions = [];

            foreach ($config['remotes'] as $remote) {
                $instructions[] = new RemoteInstruction($remote['name'], $remote['url']);
            }

            foreach ($config['links'] as $link) {
                $instructions[] = new LinkInstruction($link['source'], $link['target']);
            }

            foreach ($config['imports'] as $import) {
                $instructions[] = new ImportInstruction($import['name'], $import['path']);
            }

            return $instructions;
        } catch (ParseException $e) {
            throw new Exception\ParseException(sprintf("Unable to parse the YAML string: %s", $e->getMessage()), $e);
        }
    }
}
