<?php

namespace User\ComposerTest\Template;

use User\ComposerTest\CodeBuilder\CodeBuilder;
use User\ComposerTest\Complier\Local\Compiler;

/**
 * Данный класс только как шаблон
 */
class Lang{
    private string $compiler;
    private string $codeBuilder;
    private string $folderCompiler;
    private string $typeFile;
    private string $command;

    public function __construct(string $compiler,string $codeBuilder,string $folderCompiler,string $typeFile,string $command){
        $this->compiler = $compiler;
        $this->codeBuilder = $codeBuilder;
        $this->folderCompiler = $folderCompiler;
        $this->typeFile = $typeFile;
        $this->command = $command;
    }

    public function getCodeBuilder(string $code,array $vars,string $activeCode) : CodeBuilder{
        return new $this->codeBuilder($code,$vars,$activeCode);
    }

    public function getCompiler():Compiler{
        return new $this->compiler();
    }

    public function getFolderCompiler() : string{
        return $this->folderCompiler;
    }

    public function getTypeFile() : string{
        return $this->typeFile;
    }
    public function getCommand() : string{
        return $this->command;
    }
}