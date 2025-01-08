<?php

namespace User\ComposerTest\CodeBuilder;

use Exception;
use User\ComposerTest\Helper\Main\ArrayHelper;
use User\ComposerTest\Helper\Main\CodeBuilderHelper;
use User\ComposerTest\Helper\Java\JavaBuilderHelper;

class JavaCodeBuilder extends CodeBuilder{
    const startClassCode = "Main";
    private string $importJson = "import com.fasterxml.jackson.core.JsonProcessingException;
                                  import com.fasterxml.jackson.databind.ObjectMapper;";
                                  
    public function setVars(array $vars){
        $this->vars = JavaBuilderHelper::getVarToString($vars);
    }

    public function setActiveCode(string $activeCode){
        list($class,$method,$sepotator,$activeCodeSeporator) = $this->getSeporatorActiveCode($activeCode);

        if(!ArrayHelper::searchArray($sepotator,$activeCodeSeporator)){
            throw new Exception("Вы не правильно активируете класс");
        }
        
        list($classVar,$classArg) = CodeBuilderHelper::getClassAndArg($class);
        list($methodVar,$methodArg) = CodeBuilderHelper::getMethodAndArg($method);
        
        if($sepotator == "::"){
            $this->activeCode = "System.out.print(new ObjectMapper().writeValueAsString($classVar.$methodVar($methodArg)));";
            return;
        }
        if($sepotator == "->"){
            $classVarToLower = strtolower($class);
            $this->activeCode = "$classVar $classVarToLower = new $classVar($classArg);
            System.out.print(new ObjectMapper().writeValueAsString($classVarToLower.$methodVar($methodArg)));";
            return;
        }
    }
    public function getCode() : string{
        $betweenCodeMain = $this->vars . $this->activeCode;
        $result = $this->importJson . JavaBuilderHelper::setMainClass(self::startClassCode, $betweenCodeMain) . $this->resultCode;
        $this->reset();
        return $result;
    }
}