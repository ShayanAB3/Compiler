<?php

namespace Test\Unit\ComposerTest\CodeBuilder;

use PHPUnit\Framework\TestCase;
use User\ComposerTest\CodeBuilder\PhpCodeBuilder;
use User\ComposerTest\Complier\Local\PhpCompiler;
use User\ComposerTest\Executor\ExecutorResult;

class PhpCodeBuilderTest extends TestCase{
    protected function setUp(): void{
        
    }
    
    /** @test */
    public function compileCallClass(){
        $code = '<?php
        class Test{
            public function addTwoNum(int $a,int $b):int{
                return $a+$b;
            }
        }';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "Test->addTwoNum(5,2)";
        $codeBuilder = new PhpCodeBuilder($code,$vars,$activeCode);
        $compiler = new PhpCompiler();
        $result = $compiler->compile($codeBuilder->getCode());
        $this->assertEquals(false,$result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

     /** @test */
     public function compileCallStaticClass(){
        $code = '<?php
        class Test{
            public static function addTwoNum(int $a,int $b):int{
                return $a+$b;
            }
        }';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "Test::addTwoNum(a,b)";
        $codeBuilder = new PhpCodeBuilder($code,$vars,$activeCode);
        $compiler = new PhpCompiler();
        $result = $compiler->compile($codeBuilder->getCode());
        $this->assertEquals(false,$result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }
    
    /** @test */
    public function compileFunction(){
        $code = '<?php
        function addTwoNum(int $a,int $b) : int{
            return $a+$b;
        }';
        $vars = ["a" => 5, "b" => 2];
        $activeCode = "addTwoNum(a,b)";
        $codeBuilder = new PhpCodeBuilder($code,$vars,$activeCode);
        $code = $codeBuilder->getCode();
     
        $compiler = new PhpCompiler();
        $result = $compiler->compile($code);

        $this->assertEquals(false,$result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }
}