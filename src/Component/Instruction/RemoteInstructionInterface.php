<?php

namespace DotfilesInstaller\Component\Instruction;

interface RemoteInstructionInterface extends InstructionInterface
{
    const NO_ORIGIN_REMOTE = 'NO_ORIGIN_REMOTE';
    const BAD_ORIGIN_REMOTE = 'BAD_ORIGIN_REMOTE';
    const HAS_CHANGES = 'HAS_CHANGES';
    const IS_NOT_UP_TO_DATE = 'IS_NOT_UP_TO_DATE';

    public function getName();

    public function getUrl();

    public function getPath();
}
