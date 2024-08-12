<?php

namespace Thiagomeloo\GitSimulatorPhp\Traits;

trait HasOutput
{
    protected static function info(string $message): void
    {
        echo "\033[0;32m$message\033[0m\n";
    }

    protected static function error(string $message): void
    {
        echo "\033[0;31m$message\033[0m\n";
    }

    protected static function warning(string $message): void
    {
        echo "\033[0;33m$message\033[0m\n";
    }

    protected static function success(string $message): void
    {
        echo "\033[0;32m$message\033[0m\n";
    }
}
