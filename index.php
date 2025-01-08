<?php

use User\ComposerTest\CodeBuilder\PhpCodeBuilder;
use User\ComposerTest\Complier\Api\ApiCompiler;
use User\ComposerTest\Complier\Api\Enum\HttpMethodEnum;
use User\ComposerTest\Complier\Api\Http\HttpRequest;
use User\ComposerTest\Complier\Api\Http\HttpResponce;
use User\ComposerTest\Complier\Local\PhpCompiler;
use User\ComposerTest\Executor\ExecutorResult;

require __DIR__ . "/vendor/autoload.php";    

$code = '<?php
function addTwoNum(int $a,int $b) : int{
    return $a+$b;
}
';
$vars = ["a" => 5, "b" => 2];
$activeCode = "addTwoNum(a,b)";
$codeBuilder = new PhpCodeBuilder($code,$vars,$activeCode);
$code = $codeBuilder->getCode();

$compiler = new PhpCompiler();
$result = $compiler->compile($code);
var_dump($result);