<?php

namespace User\ComposerTest\Complier\Local;

use User\ComposerTest\Config\LangProgConfig;
use User\ComposerTest\Exec\Enum\ConditionalExecutionEnum;
use User\ComposerTest\Exec\ExecLang;

class CppCompiler extends Compiler{
    private $lang = "cpp";
    
    public function execute(string $path,string $input) : array{
        $pathEXE = dirname($path)."/program.exe";

        $shellExec = new ExecLang(LangProgConfig::getLang($this->getLang()));
        $shellExec->setPath($path);
        $shellExec->setFlag("-o",$pathEXE);

        $shellExec->setConditionalExecution(ConditionalExecutionEnum::AND);

        $shellExec->setCommand($pathEXE);
        $shellExec->setInput($input);
       
        return $shellExec->execute();
    }

    public function getLang(): string{
        return $this->lang;
    }
}