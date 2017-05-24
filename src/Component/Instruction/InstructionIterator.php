<?php

namespace DotfilesInstaller\Component\Instruction;

use DotfilesInstaller\Component\Instruction\Loader\Exception\LoaderException;

class InstructionIterator implements \Iterator
{
    protected $position;

    protected $instructions;

    protected $mainInstruction;

    protected $loader;

    public function __construct(
        InstructionInterface $mainInstruction,
        Loader\InstructionLoaderInterface $loader
    ) {
        $this->mainInstruction = $mainInstruction;
        $this->loader = $loader;
        $this->position = 0;
        $this->instructions = [$this->mainInstruction];
    }

    public function rewind()
    {
        $this->position = 0;
        $this->instructions = [$this->mainInstruction];
    }

    public function current()
    {
        return $this->instructions[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->load();

        ++$this->position;
    }

    public function valid()
    {
        return isset($this->instructions[$this->position]);
    }

    protected function load()
    {
        if (!$this->valid()) {
            return;
        }

        if (!$this->current()->getDotfile()) {
            return;
        }

        try {
            $loadedInstructions = $this->loader->load($this->current()->getDotfile());

            array_splice($this->instructions, $this->position + 1, 0, $loadedInstructions);
        } catch (LoaderException $e) {

        }
    }
}
