<?php

use PHPUnit\Framework\TestCase;
use User\ComposerTest\Complier\Local\JavaCompiler;
use User\ComposerTest\Executor\ExecutorResult;

class JavaCompilerTest extends TestCase{
    protected JavaCompiler $javaCompiler;

    protected function setUp(): void{
        $this->javaCompiler = new JavaCompiler();    
    }

     /** @test */
     public function compileWithoutInput(){
        $result = $this->javaCompiler->compile('
        class Main{
            public static void main(String[] args){
                int a = 5;
                int b = 6;
                Test test = new Test();
                System.out.print(test.addTwoNum(a,b));
            }
        }
        class Test{
            public int addTwoNum(int a,int b){
                return a+b;
            }
        }');
        
        $this->assertFalse($result->getIsError());
        $this->assertEquals(11,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

    /** @test */
    public function compileWithInput(){
        $input = [4,3];
        $result = $this->javaCompiler->compile('
        class Main{
            public static void main(String[] args){
                int a = Integer.parseInt(args[0]);
                int b = Integer.parseInt(args[1]);
                System.out.print(Test.addTwoNum(a,b));
            }
        }
        class Test{
            public static int addTwoNum(int a,int b){
                return a+b;
            }
        }',$input);
        
        $this->assertFalse($result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

    /** @test */
    public function compileFile(){
        $path = getcwd()."/src/TestFilesCompiler/Java/Main.java";
        $result = $this->javaCompiler->compileFile($path);
        $this->assertFalse($result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }
}