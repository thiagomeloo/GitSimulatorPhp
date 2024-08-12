<?php

namespace Thiagomeloo\GitSimulatorPhp\Enums;

enum CommitCommands: string
{
    case COMMIT = "git commit -m '%s'";
    case COMMI_ADD = "git add %s";
    case COMMIT_ALL = "git commit -a -m '%s'";

    public function get(?string $name = null): string
    {
        return sprintf($this->value, $name);
    }
}
