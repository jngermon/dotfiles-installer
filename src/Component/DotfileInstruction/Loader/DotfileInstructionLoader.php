<?php

namespace DotfilesInstaller\Component\DotfileInstruction\Loader;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class DotfileInstructionLoader implements DotfileInstructionLoaderInterface
{
    public function load($path)
    {
        if (!file_exists($path)) {
            throw new Exception\FileNotFoundException(sprintf('Unable to find the file "%s"', $path));
        }

        try {
            $value = Yaml::parse(file_get_contents($path));
            var_dump($value);
        } catch (ParseException $e) {
            throw new Exception\ParseException(sprintf("Unable to parse the YAML string: %s", $e->getMessage()), $e);
        }
    }
}
