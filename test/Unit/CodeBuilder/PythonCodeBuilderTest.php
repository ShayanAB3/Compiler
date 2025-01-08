<?php

namespace Test\Unit\ComposerTest\CodeBuilder;

use PHPUnit\Framework\TestCase;
use User\ComposerTest\CodeBuilder\PythonCodeBuilder;
use User\ComposerTest\Complier\Local\PythonCompiler;
use User\ComposerTest\Executor\ExecutorResult;

class PythonCodeBuilderTest extends TestCase{
    protected PythonCompiler $pythonCompiler;
    protected function setUp(): void{
        $this->pythonCompiler = new PythonCompiler();
    }

    /** @test */
    public function compileCallClass(){
        $code = '
        class Test:
            def addTwoNum(self,a,b):
                return a+b
        ';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "Test->addTwoNum(a,b)";
        $codeBuilder = new PythonCodeBuilder($code,$vars,$activeCode);
        $pythonCompiler = new PythonCompiler();
        $result = $pythonCompiler->compile($codeBuilder->getCode());

        $this->assertEquals(false,$result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

     /** @test */
     public function compileCallStaticClass(){
        $code = '
        class Test:
            @staticmethod
            def addTwoNum(a,b):
                return a+b
        ';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "Test::addTwoNum(a,b)";
        $codeBuilder = new PythonCodeBuilder($code,$vars,$activeCode);
        $result = $this->pythonCompiler->compile($codeBuilder->getCode());
        $this->assertEquals(false,$result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }
    
    /** @test */
    public function compileFunction(){
        $code = '
        def addTwoNum(a,b):
            return a+b
        ';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "addTwoNum(a,b)";
        $codeBuilder = new PythonCodeBuilder($code,$vars,$activeCode);
        $result = $this->pythonCompiler->compile($codeBuilder->getCode());
        $this->assertEquals(false,$result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }
}