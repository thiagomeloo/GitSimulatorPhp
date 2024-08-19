<?php

namespace Thiagomeloo\GitSimulatorPhp\Enums;

enum BranchCommands: string
{
    case BRANCH_CREATE = "git branch %s";
    case BRANCH_DELETE = "git branch -D %s";
    case BRANCH_CHECKOUT = "git checkout %s";
    case BRANCH_CHECKOUT_CREATE = "git checkout -b %s";
    case BRANCH_CURRENT = "git symbolic-ref --short HEAD";
    case BRANCH_LIST = "git branch";
    case BRANCH_MERGE = "git merge %s";
    case BRANCH_PUSH = "git push origin %s";
    case BRANCH_PULL = "git pull origin %s";


    public function get(?string $name = null): string
    {
        return sprintf($this->value, $name);
    }
}
