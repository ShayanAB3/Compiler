<?php

namespace User\ComposerTest\CodeBuilder;

use User\ComposerTest\Helper\Main\CodeBuilderHelper;

class PhpCodeBuilder extends CodeBuilder{

    public function setVars(array $vars){
        foreach($vars as $key => $value){
            $value = json_encode($value);
            $this->resultCode .= "$$key = $value;\n";
        }
    }
    
    public function setActiveCode(string $activeCode){
        list($class,$method,$sepotator) = $this->getSeporatorActiveCode($activeCode);
    
        if($class !== "" && $method !== ""){
            list($classVar,$classArg) = CodeBuilderHelper::getClassAndArg($class,"$");
            list($methodVar,$methodArg) = CodeBuilderHelper::getMethodAndArg($method,"$");
        }

        if($sepotator == "->"){
            $this->resultCode .= "$$classVar = new $classVar($classArg);\n";
            $this->resultCode .= "echo json_encode($$classVar->$methodVar($methodArg));";
            return;
        }
        if($sepotator == "::"){
            $this->resultCode .= "echo json_encode($classVar::$methodVar($methodArg));";
            return;
        }

        list($functionVar,$functionArg) = CodeBuilderHelper::getMethodAndArg($activeCode,"$");
        $this->resultCode .= "\necho json_encode($functionVar($functionArg));\n";
    }

    public function getCode() : string{
        $resultCode = $this->resultCode;
        $this->reset();
        return $resultCode;
    }
}