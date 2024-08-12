<?php

namespace Thiagomeloo\GitSimulatorPhp\Traits;

trait HasCommand
{
    protected static function executeCommand(string $command): string
    {
        $output = shell_exec("$command 2>/dev/null");

        return  "$output";
    }
}
