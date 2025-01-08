<?php

namespace User\ComposerTest\CodeBuilder;

use User\ComposerTest\Helper\Main\CodeBuilderHelper;
use User\ComposerTest\Helper\Python\PythonBuilderHelper;

class PythonCodeBuilder extends CodeBuilder{
    private string $importJson = "import json\n";

    public function setVars(array $vars){
        foreach($vars as $key => $value){
            $value = json_encode($value);
            $this->resultCode .= "\n$key = $value\n";
        }
    }
    
    public function setActiveCode(string $activeCode){
        list($class,$method,$sepotator) = $this->getSeporatorActiveCode($activeCode);
    
        if($class !== "" && $method !== ""){
            list($className,$classArg) = CodeBuilderHelper::getClassAndArg($class);
            list($methodName,$methodArg) = CodeBuilderHelper::getMethodAndArg($method);
            $classVar = strtolower($className);
        }

        if($sepotator == "->"){
            $this->resultCode .= "$classVar = $className($classArg)";
            $this->resultCode .= "\nprint(json.dumps($classVar.$methodName($methodArg)))";
            return;
        }
        if($sepotator == "::"){
            $this->resultCode .= "\nprint(json.dumps($className.$methodName($methodArg)))";
            return;
        }
    
        list($functionName,$functionArg) = CodeBuilderHelper::getMethodAndArg($activeCode);
        $this->resultCode .= "\nprint(json.dumps($functionName($functionArg)))\n";
    }
   
    public function getCode() : string{
        $resultCode = $this->resultCode;
        $this->reset();
        return PythonBuilderHelper::formatCode($this->importJson . $resultCode);
    }
}