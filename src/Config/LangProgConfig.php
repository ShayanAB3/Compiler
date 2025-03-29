<?php

namespace User\ComposerTest\Config;

use Exception;
use User\ComposerTest\Template\Lang;

use User\ComposerTest\Complier\Local\PhpCompiler;
use User\ComposerTest\CodeBuilder\PhpCodeBuilder;

use User\ComposerTest\Complier\Local\PythonCompiler;
use User\ComposerTest\CodeBuilder\PythonCodeBuilder;

use User\ComposerTest\Complier\Local\JavaCompiler;
use User\ComposerTest\CodeBuilder\JavaCodeBuilder;

use User\ComposerTest\Complier\Local\CppCompiler;
use User\ComposerTest\CodeBuilder\CppCodeBuilder;

class LangProgConfig{
    public static array $langList = [
        "php" => [
            "compiler" => PhpCompiler::class,
            "codeBuilder" => PhpCodeBuilder::class,
            "folderCompiler" => "PHP",
            "typeFile" => ".php",
            "command" => "php"
        ],
        "python" => [
            "compiler" => PythonCompiler::class,
            "codeBuilder" => PythonCodeBuilder::class,
            "folderCompiler" => "Python",
            "typeFile" => ".py",
            "command" => "python3"
        ],
        "java" => [
            "compiler" => JavaCompiler::class,
            "codeBuilder" => JavaCodeBuilder::class,
            "folderCompiler" => "Java",
            "typeFile" => ".java",
            "command" => "java"
        ],
        "cpp" => [
            "compiler" => CppCompiler::class,
            "codeBuilder" => CppCodeBuilder::class,
            "folderCompiler" => "C++",
            "typeFile" => ".cpp",
            "command" => "g++"
        ]
    ];

    public static function getLang(string $key) : Lang{
        if(!array_key_exists($key,self::$langList)){
            throw new Exception("Такой язык программирование не существует!");
        }
        return new Lang(...self::$langList[$key]);
    }
}