<?php

namespace Thiagomeloo\GitSimulatorPhp;

use Thiagomeloo\GitSimulatorPhp\Enums\BranchCommands;
use Thiagomeloo\GitSimulatorPhp\Enums\CommitCommands;
use Thiagomeloo\GitSimulatorPhp\Enums\TypeTasks;
use Thiagomeloo\GitSimulatorPhp\Traits\HasCommand;
use Thiagomeloo\GitSimulatorPhp\Traits\HasOutput;

class GitSimulatorPhp
{
    use HasOutput;
    use HasCommand;

    private readonly string $branchName;

    public function __construct()
    {
        $this->branchName = self::executeCommand(
            BranchCommands::BRANCH_CURRENT->get()
        );

        if ($this->branchName === null || $this->branchName === "") {
            self::error("fatal: not a git repository (or any of the parent directories): .git");
            exit(1);
        }

        self::info("On branch $this->branchName");

        $this->run();
    }

    private function run(string $prefixId = "DEV", string $typeTask = null): void
    {
        if ($typeTask === null) {
            $typeTask = TypeTasks::random()->value;

            echo "Type task: $typeTask\n";
        }

        $files = scandir("src");

        usort($files, function ($a, $b) {
            $numA = intval(explode('-', $a)[0]);
            $numB = intval(explode('-', $b)[0]);

            return $numA <=> $numB;
        });

        $files = array_filter($files, function ($file) {
            return !in_array($file, ['.', '..']) && $file !== '';
        });

        if (count($files) === 0) {
            $lastFileId = 0;
            $lastType = $typeTask;
            $lastTaskId = 0;
        } else {
            [$lastFileId, $lastType, $lastTaskId] = explode(
                "-",
                end($files)
            );
        }


        $lastFileId = (int) $lastFileId;

        $branchId = $lastTaskId + 1;
        $branchName = "$typeTask/$prefixId-$branchId";

        self::executeCommand(
            BranchCommands::BRANCH_CHECKOUT_CREATE->get($branchName)
        );

        $numberOfFiles = rand(1, 4);

        for($i = $lastFileId + 1; $i <= $lastFileId + $numberOfFiles; $i++) {
            $fileName = "src/$i-$typeTask-$branchId";

            self::info("Creating file $fileName");
            touch($fileName);

            foreach (range(1, rand(1, 10)) as $line) {
                file_put_contents($fileName, "Line $line\n", FILE_APPEND);
            }

            self::info("Adding file $fileName");
            self::executeCommand(CommitCommands::COMMI_ADD->get($fileName));

            self::info("Commiting file $fileName");
            self::executeCommand(
                CommitCommands::COMMIT->get("$prefixId-$branchId: Add $fileName")
            );
        }

        if(
            in_array(
                $typeTask,
                [TypeTasks::BUGFIX->value, TypeTasks::HOTFIX->value]
            )
            && count($files) > 25
        ) {

            $firstFile = array_shift($files);

            self::info("Removing file $firstFile");
            unlink("src/$firstFile");

            self::executeCommand(
                CommitCommands::COMMIT->get("$prefixId-$branchId: Remove $firstFile")
            );
        }

        self::info("Returning to branch $this->branchName");
        self::executeCommand(
            BranchCommands::BRANCH_CHECKOUT->get($this->branchName)
        );

        self::info("Merging branch $branchName");
        self::executeCommand(
            BranchCommands::BRANCH_MERGE->get($branchName)
        );

        self::success("Successfully!");

    }


}
