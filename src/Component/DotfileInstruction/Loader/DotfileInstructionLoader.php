<?php

namespace DotfilesInstaller\Component\DotfileInstruction\Loader;

use DotfilesInstaller\Component\DotfileInstruction\Configuration;
use DotfilesInstaller\Component\DotfileInstruction\DotfileImportInstruction;
use DotfilesInstaller\Component\DotfileInstruction\DotfileLinkInstruction;
use DotfilesInstaller\Component\DotfileInstruction\DotfileRemoteInstruction;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class DotfileInstructionLoader implements DotfileInstructionLoaderInterface
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
                $instructions[] = new DotfileRemoteInstruction($remote['name'], $remote['url']);
            }

            foreach ($config['links'] as $link) {
                $instructions[] = new DotfileLinkInstruction($link['source'], $link['target']);
            }

            foreach ($config['imports'] as $import) {
                $instructions[] = new DotfileImportInstruction($import['name'], $import['path']);
            }

            return $instructions;
        } catch (ParseException $e) {
            throw new Exception\ParseException(sprintf("Unable to parse the YAML string: %s", $e->getMessage()), $e);
        }
    }
}
