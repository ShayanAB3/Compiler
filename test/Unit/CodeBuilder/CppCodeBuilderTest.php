<?php

namespace Test\Unit\ComposerTest\CodeBuilder;

use PHPUnit\Framework\TestCase;
use User\ComposerTest\CodeBuilder\CppCodeBuilder;
use User\ComposerTest\Complier\Local\CppCompiler;
use User\ComposerTest\Executor\ExecutorResult;

class CppCodeBuilderTest extends TestCase{
    protected CppCompiler $cppCompiler;

    protected function setUp(): void{
        $this->cppCompiler = new CppCompiler();
    }

    /** @test */
    public function compileCallClass(){
        $code = 'class Test {
        public:
            int addTwoNum(int a, int b) {
                return a + b;
            }
        };';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "Test->addTwoNum(a,b)";
        $codeBuilder = new CppCodeBuilder($code,$vars,$activeCode);
        $result = $this->cppCompiler->compile($codeBuilder->getCode());
        $this->assertEquals(false,$result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

     /** @test */
     public function compileCallStaticClass(){
        $code = 'class Test {
        public:
            static int addTwoNum(int a, int b) {
                return a + b;
            }
        };';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "Test::addTwoNum(a,b)";
        $codeBuilder = new CppCodeBuilder($code,$vars,$activeCode);

        $result = $this->cppCompiler->compile($codeBuilder->getCode());
        $this->assertEquals(false,$result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }
    
    /** @test */
    public function compileFunction(){
        $code = 'int addTwoNum(int a, int b) {
            return a + b;
        }';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "addTwoNum(a,b)";
        $codeBuilder = new CppCodeBuilder($code,$vars,$activeCode);
        $code = $codeBuilder->getCode();
     
        $result = $this->cppCompiler->compile($code);
        $this->assertEquals(false,$result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }
}