# Compiler

## Local compiler
Local compilers are compilers that are executed via console commands.

## Example:
```
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
```

My project has two important components Compiler and Code Builder.

## Compiler
A compiler is a whole family of classes with specific programming languages. 
List of compiler classes:
- `User\ComposerTest\Complier\Local\PythonCompiler`
- `User\ComposerTest\Complier\Local\PhpCompiler`
- `User\ComposerTest\Complier\Local\JavaCompiler`
- `User\ComposerTest\Complier\Local\CppCompiler`

## Code Builder
The code collector generates program code based on variables, methods or functions, and the strings used to call the method.
List of code builder classes:
- `User\ComposerTest\CodeBuilder\PythonCodeBuilder`
- `User\ComposerTest\CodeBuilder\PhpCodeBuilder`
- `User\ComposerTest\CodeBuilder\JavaCodeBuilder`
- `User\ComposerTest\CodeBuilder\CppCodeBuilder`

## Syntax active method or function to Code Builder
Function: `function_name(a,b)` or `function_name(5,"a")`

Method: `Classname->method_name(a,b)` or `Classname->method_name(5,"a")`

Static method: `Classname::method_name(a,b)` or `Classname::method_name(5,"a")`

## Api compiler
### Example:
```
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
```
