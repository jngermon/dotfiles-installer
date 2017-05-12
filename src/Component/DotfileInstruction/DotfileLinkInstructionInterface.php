<?php

namespace DotfilesInstaller\Component\DotfileInstruction;

interface DotfileLinkInstructionInterface
{
    public function getSource();

    public function getTarget();
}
