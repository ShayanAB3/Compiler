<?php

namespace Test\Unit\ComposerTest\CodeBuilder;

use PHPUnit\Framework\TestCase;
use User\ComposerTest\CodeBuilder\JavaCodeBuilder;
use User\ComposerTest\Complier\Local\JavaCompiler;
use User\ComposerTest\Executor\ExecutorResult;

class JavaCodeBuilderTest extends TestCase{
    protected function setUp(): void{
        
    }

    /** @test */
    public function compileCallClass(){
        $code = '
        class Test{
            public int addTwoNum(int a,int b){
                return a+b;
            }
        }';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "Test->addTwoNum(5,2)";
        $codeBuilder = new JavaCodeBuilder($code,$vars,$activeCode);
        $compiler = new JavaCompiler();
        $result = $compiler->compile($codeBuilder->getCode());
        
        $this->assertInstanceOf(ExecutorResult::class,$result);
        $this->assertFalse($result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
    }

    /** @test */
    public function compileCallStaticClass(){
        $code = '
        class Test{
            public static int addTwoNum(int a,int b){
                return a+b;
            }
        }';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "Test::addTwoNum(a,b)";
        $codeBuilder = new JavaCodeBuilder($code,$vars,$activeCode);
        $compiler = new JavaCompiler();
        $result = $compiler->compile($codeBuilder->getCode());

        $this->assertInstanceOf(ExecutorResult::class,$result);
        $this->assertFalse($result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
    }
}