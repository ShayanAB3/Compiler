<?php


namespace Test\Unit\ComposerTest\Compliler;

use PHPUnit\Framework\TestCase;
use User\ComposerTest\Complier\Local\PhpCompiler;
use User\ComposerTest\Executor\ExecutorResult;

class PhpCompilerTest extends TestCase{
    protected PhpCompiler $phpCompiler;

    public function setUp(): void{
        $this->phpCompiler = new PhpCompiler();
    }

    /** @test */
    public function compileWithoutInput(){
        $result = $this->phpCompiler->compile('<?php
        class Test{
            public function addTwoNum(int $a,int $b):int{
                return $a+$b;
            }
        }
        $a = 5;
        $b = 6;
        $test = new Test();
        echo json_encode($test->addTwoNum($a,$b));');
        $this->assertFalse($result->getIsError());
        $this->assertEquals(11,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

    /** @test */
    public function compileWithInput(){
        $input = [4,3];
        $result = $this->phpCompiler->compile('<?php
        class Test{
            public function addTwoNum(int $a,int $b):int{
                return $a+$b;
            }
        }
        $a = $argv[1];
        $b = $argv[2];
        $test = new Test();
        echo json_encode($test->addTwoNum($a,$b));',$input);
        $this->assertFalse($result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

    /** @test */
    public function compileFile(){
        $path = "C:\Projects\ComposerTest\src\TestFilesCompiler\PHP\\test1.php";
        $result = $this->phpCompiler->compileFile($path);
        $this->assertFalse($result->getIsError());
        $this->assertEquals(11,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }
}