<?php

use User\ComposerTest\CodeBuilder\CppCodeBuilder;
use User\ComposerTest\Complier\Local\CppCompiler;
 
require __DIR__ . "/vendor/autoload.php";    

$code = 'class Test {
    public:
        int addTwoNum(int a, int b) {
            return a + b;
        }
    };';
$vars = ["a" => 5, "b" => 2];
$activeCode = "Test->addTwoNum(a,b)";
$codeBuilder = new CppCodeBuilder($code,$vars,$activeCode);
$compiler = new CppCompiler();
$result = $compiler->compile($codeBuilder->getCode());