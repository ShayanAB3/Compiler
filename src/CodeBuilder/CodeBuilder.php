<?php

namespace User\ComposerTest\CodeBuilder;

use Exception;
use User\ComposerTest\Helper\Main\ArrayHelper;

abstract class CodeBuilder{
    protected string $resultCode = "";
    public string $activeCode;
    public string $vars;
    /**
     * Вносятся переменные
     * Пример: setVars(["a" => 5, "b" => 2]) ==> PHP: $a = 5; $b = 2; 
     * 
     * @param array $vars
     * @return void
     */
    abstract public function setVars(array $vars);
    /**
     * Вызов функций или метода в классе
     * Пример: 
     * setActiveCode("function") ==> PHP: function();
     * setActiveCode("Class->method") ==> PHP: $class = new Class(); $class->method();
     * setActiveCode("Class::staticMethod") ==> PHP: Class::staticMethod();
     * 
     * Также вы можете вносить параметры в функций и методы, а также конструкторы класса;
     * Пример: 
     * setActiveCode("function(a,b)") ==> PHP: function($a,$b);
     * setActiveCode("Class->method(a,b)") ==> PHP: $class = new Class(); $class->method($a,$b);
     * setActiveCode("Class(a,b)->method(a,b)") ==> PHP: $class = new Class($a,$b); $class->method($a,$b);
     * setActiveCode("Class::staticMethod") ==> PHP: Class::staticMethod();
     * 
     * 
     * @param string $activeCode
     * @return void
     */
    abstract public function setActiveCode(string $activeCode);
    /**
     * Получаем результат кода
     * @return string
     */
    abstract public function getCode(): string;

    public function __toString() : string{
        return $this->getCode();
    }

    public function __construct(string $code = "",array $vars = [],string $activeCode = ""){
        $this->setResultCode($code);
        $this->checkSetVars($vars);
        $this->setVars($vars);
        $this->setActiveCode($activeCode);
    }
    private function checkSetVars(array $vars){
        if(!ArrayHelper::isAssociativeArray($vars) && count($vars) !== 0){
            throw new Exception("Input должен быть ассоциативным массивом");
        }
    }

    public function setResultCode(string $resultCode){
        $this->resultCode = trim($resultCode);
    }
    public function reset(){
        $this->activeCode = "";
        $this->resultCode = "";
        $this->vars = "";
    }
    protected function getSeporatorActiveCode(string $activeCode) : array{
        $activeCodeSeporator = ["->","::"];
        foreach($activeCodeSeporator as &$value){
            if(strpos($activeCode,$value)){
                list($class,$method) = explode($value,$activeCode);
                $sepotator = $value;
            }
        }
        $class = !isset($class) ? "" : $class;
        $method = !isset($method) ? "" : $method;
        $sepotator = !isset($sepotator) ? "" : $sepotator;
        
        return [$class,$method,$sepotator,$activeCodeSeporator];
    }
}