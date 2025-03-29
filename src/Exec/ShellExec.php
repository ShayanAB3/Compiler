<?php

namespace User\ComposerTest\Exec;

use User\ComposerTest\Exec\Enum\ConditionalExecutionEnum;

abstract class ShellExec{
    protected array $commandLine = [];
    const RedirectStdOutInStdErr = "2>&1";

    protected function shellExec(string $command): array{
        $redirectStd = self::RedirectStdOutInStdErr;
        exec("$command $redirectStd",$output,$resultCode);
        return [$output,$resultCode];
    }

    public function setConditionalExecution(ConditionalExecutionEnum $conditionalExecution){
        $this->commandLine[] = $conditionalExecution->value;
    }

    public function setCommand(string $command){
        $this->commandLine[] = $command;
    }

    public function getCommand() : string{
        return implode(" ",$this->commandLine);
    }

    public function execute() : array{
        $command = $this->getCommand();
        list($output,$resultCode) = $this->shellExec($command);
        return [$output,$resultCode];
    }
}