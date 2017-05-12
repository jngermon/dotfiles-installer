<?php

namespace DotfilesInstaller\Component\Util;

class PathConverter
{
    public function convert($path)
    {
        return preg_replace('/\~/', $_SERVER['HOME'], $path);
    }
}
