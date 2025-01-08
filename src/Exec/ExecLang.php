<?php

namespace User\ComposerTest\Exec;

use Exception;
use User\ComposerTest\Helper\Main\FileCompiler;
use User\ComposerTest\Template\Lang;

class ExecLang extends ShellExec{
    public function __construct(Lang $lang){
        $this->setCommandLang($lang->getCommand());    
    }

    private function setCommandLang(string $command){
        list($output,$resultCode) = $this->shellExec("$command --version");
        if($resultCode){
            throw new Exception("Ошибка такой язык программирование не существует!\nКоманда: $command\nВывод: $output");
        }
        $this->commandLine[] = $command;
    }

    public function setPath(string $path){
        if(!FileCompiler::isFile($path)){
            throw new Exception("Файл $path не существует!");
        }
        $this->commandLine[] = $path;
    }

    public function setInput(string $input){
        $this->commandLine[] = $input;
    }

    public function setFlag(string $flag,string $value){
        if(strpos($flag,"-") === false && strpos($flag, "/") === false){
            throw new Exception("Вы не верно обьявили флаг. Будет правильно использовать -[flag] или --[fullFlag], а иногда /[flag].");
        }
        $this->commandLine[] = "$flag $value";
    }
}