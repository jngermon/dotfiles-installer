<?php

namespace DotfilesInstaller\Component\Util;

class PathConverter
{
    public function convert($path, $root = '')
    {
        $path = preg_replace('/\~/', $_SERVER['HOME'], $path);

        if ($root && !preg_match('/^\\'.DIRECTORY_SEPARATOR.'/', $path)) {
            $path = $root.DIRECTORY_SEPARATOR.$path;
        }

        return $path;
    }
}
