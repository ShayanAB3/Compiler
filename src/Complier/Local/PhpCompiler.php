<?php

namespace User\ComposerTest\Complier\Local;

use User\ComposerTest\Config\LangProgConfig;
use User\ComposerTest\Exec\ExecLang;

class PhpCompiler extends Compiler{
    public string $lang = "php";

    public function execute(string $path,string $input) : array{
        $shellExec = new ExecLang(LangProgConfig::getLang($this->getLang()));
        $shellExec->setPath($path);
        $shellExec->setInput($input);

        return $shellExec->execute();
    }

    public function getLang():string{
        return $this->lang;
    }
}