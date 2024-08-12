<?php

namespace Thiagomeloo\GitSimulatorPhp\Enums;

enum TypeTasks: string
{
    case FEATURE = "feature";
    case BUGFIX = "bugfix";
    case HOTFIX = "hotfix";
    case ENHANCEMENT = "enhancement";

    public static function random(): self
    {
        return self::cases()[array_rand(self::cases())];
    }
}
