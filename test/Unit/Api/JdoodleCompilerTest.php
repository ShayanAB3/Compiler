<?php

namespace Test\Unit\ComposerTest\Api;

use PHPUnit\Framework\TestCase;

use User\ComposerTest\Executor\ExecutorResult;
use User\ComposerTest\Complier\Api\Enum\HttpMethodEnum;
use User\ComposerTest\Complier\Api\Http\HttpRequest;
use User\ComposerTest\Complier\Api\Http\HttpResponce;
use User\ComposerTest\Complier\Api\ApiCompiler;
use User\ComposerTest\MainCompiler;

class JdoodleCompiler extends ApiCompiler{
    public function execute(HttpResponce $response): ExecutorResult{
        $body = $response->getResponce()->output;
        $responseIsError = !$response->getExtensionCode(200);
        return new ExecutorResult($this->code,$body,$responseIsError,$this->lang);
    }

    public function options(): HttpRequest{
        $option = new HttpRequest("https://api.jdoodle.com/v1/execute",HttpMethodEnum::POST);
        $option->setBody([
            "clientId" => "2f6a7ab46921a79a6aa5aab650676e04",
            "clientSecret" => "a6cedd5fb8b3fb0bf0a09dbe83b61ec49398323f4130490e529353863c97f491",
            "language" => $this->lang,
            "script" => $this->code,
            "versionIndex" => "0"
        ]);
        $option->setHeaders([
            "Content-Type" => "application/json"
        ]);
        return $option;
    }
}

class JdoodleCompilerTest extends TestCase{
    protected function setUp(): void{

    }

    /** @test */
    public function compile(){
        $jdoodleCompiler = new JdoodleCompiler("php");
        $result = $jdoodleCompiler->compile("<?php echo \"Hello\" ?>");

        $this->assertFalse($result->getIsError());
        $this->assertEquals("Hello",$result->getResultCode());
    }

    /** @test */
    public function compileFile(){
        $jdoodleCompiler = new JdoodleCompiler("php");
        $file = __DIR__."/File/HelloWorld.php";
        $result = $jdoodleCompiler->compileFile($file);
        
        $this->assertFalse($result->getIsError());
        $this->assertEquals("Hello World",$result->getResultCode());
    }
}