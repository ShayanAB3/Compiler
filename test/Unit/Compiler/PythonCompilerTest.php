<?php

namespace Test\Unit\ComposerTest\Compliler;

use PHPUnit\Framework\TestCase;
use User\ComposerTest\Complier\Local\PythonCompiler;
use User\ComposerTest\Executor\ExecutorResult;

class PythonCompilerTest extends TestCase{
    protected PythonCompiler $pythonCompiler;

    public function setUp(): void{
        $this->pythonCompiler = new PythonCompiler();
    }

     /** @test */
     public function compileWithoutInput(){
        $result = $this->pythonCompiler->compile('
import json
class Test:
    def addTwoNum(self,a:int,b:int) -> int:
        return a+b

a = 5
b = 6
test = Test()
print(json.dumps(test.addTwoNum(a,b)))');
        $this->assertFalse($result->getIsError());
        $this->assertEquals(11,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

    /** @test */
    public function compileWithInput(){
        $input = [4,3];
        $result = $this->pythonCompiler->compile('
import json
import sys
class Test:
    def addTwoNum(self,a:int,b:int) -> int:
        return a+b

a = int(sys.argv[1])
b = int(sys.argv[2])
test = Test()
print(json.dumps(test.addTwoNum(a,b)))',$input);
        $this->assertFalse($result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

    /** @test */
    public function compileFile(){
        $path = getcwd()."/src/TestFilesCompiler/Python/test1.py";
        $result = $this->pythonCompiler->compileFile($path);
        $this->assertFalse($result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }
}