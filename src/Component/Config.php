<?php

namespace DotfilesInstaller\Component;

class Config
{
    protected $path;

    public function __construct(
       $path 
    ) {
        $this->path = $path;
    } 

    public function getPath()
    {
        return $this->path;
    }
}
