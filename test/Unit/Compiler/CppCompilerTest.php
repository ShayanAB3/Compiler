<?php

namespace Test\Unit\ComposerTest\Compliler;

use PHPUnit\Framework\TestCase;
use User\ComposerTest\Complier\Local\CppCompiler;
use User\ComposerTest\Executor\ExecutorResult;

class CppCompilerTest extends TestCase{
    protected CppCompiler $cppCompiler;

    public function setUp(): void{
        $this->cppCompiler = new CppCompiler();
    }

    /** @test */
    public function compileWithoutInput(){
        $result = $this->cppCompiler->compile("
        #include <iostream>
        #include <nlohmann/json.hpp>
        using json = nlohmann::json;
        class Solution {
            public:
                int twoSum(int num1,int num2) {
                    return num1 + num2;
                }
            };

        int main() {
            int num1 = 5;
            int num2 = 2;
            Solution solution;
            json j = solution.twoSum(num1,num2);
            std::cout << j << std::endl;
        }",[]);
        $this->assertFalse($result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

    /** @test */
    public function compileWithInput(){
        $input = [4,3];
        $result = $this->cppCompiler->compile("
        #include <iostream>
        #include <nlohmann/json.hpp>
        #include <stdio.h>
        using json = nlohmann::json;
        class Solution {
            public:
                int twoSum(int num1,int num2) {
                    return num1 + num2;
                }
            };

        int main(int argc,char* argv[]) {
            int num1 = std::stoi(argv[1]);
            int num2 = std::stoi(argv[2]);
            Solution solution;
            json j = solution.twoSum(num1,num2);
            std::cout << j << std::endl;
        }",$input);
        $this->assertFalse($result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

    /** @test */
    public function compileFile(){
        $path = getcwd()."/src/TestFilesCompiler/C++/Hello.cpp";
        $result = $this->cppCompiler->compileFile($path);
        $this->assertEquals(false,$result->getIsError());
        $this->assertEquals(7,$result->getResultCode());
        $this->assertInstanceOf(ExecutorResult::class,$result);
    }

    
}