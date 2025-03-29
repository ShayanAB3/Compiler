<?php

namespace User\ComposerTest\Complier\Local;

use User\ComposerTest\Config\LangProgConfig;
use User\ComposerTest\Exec\ExecLang;
use User\ComposerTest\Helper\Path\PathBuilder;
use User\ComposerTest\Config\PathConfigEnum;

class JavaCompiler extends Compiler{
    public $lang = "java";

    public function execute(string $path,string $input) : array{
        $shellExec = new ExecLang(LangProgConfig::getLang($this->getLang()));
        $realPath = realpath($path);
        $directory = dirname($realPath);
        # $directory/libs/*;. => Windows
        # $directory/libs/*:. => Linux
        $shellExec->setFlag("-cp","$directory/libs/*:.");
        $shellExec->setPath($path);
        $shellExec->setInput($input);
       
        return $shellExec->execute();
    }

    public function getLang(): string{
        return $this->lang;
    }
}