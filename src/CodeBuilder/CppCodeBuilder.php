<?php

namespace User\ComposerTest\CodeBuilder;

use User\ComposerTest\Helper\Cpp\CppBuilderHelper;
use User\ComposerTest\Helper\Main\CodeBuilderHelper;

class CppCodeBuilder extends CodeBuilder{
    private string $importJson = "#include <iostream>\n#include <nlohmann/json.hpp>\nusing json = nlohmann::json;\n";

    public function setVars(array $vars){
        $this->vars = CppBuilderHelper::getVarToString($vars);
    }
    public function setActiveCode(string $activeCode){
        list($class,$method,$sepotator) = $this->getSeporatorActiveCode($activeCode);

        if($class !== "" && $method !== ""){
            list($classType,$classArg) = CodeBuilderHelper::getClassAndArg($class);
            list($methodVar,$methodArg) = CodeBuilderHelper::getMethodAndArg($method);
            $classVar = strtolower($classType);
        }

        if($sepotator == "->"){
            $this->activeCode = "$classType $classVar$classArg;\njson j = $classVar.$methodVar($methodArg);\nstd::cout << j << std::endl;";
            return;
        }
        if($sepotator == "::"){
            $this->activeCode = "json j = $classType::$methodVar($methodArg);std::cout << j << std::endl;";
            return;
        }
    
        list($functionVar,$functionArg) = CodeBuilderHelper::getMethodAndArg($activeCode);
        $this->activeCode = "json j = $functionVar($functionArg);std::cout << j << std::endl;";
    }
    public function getCode() : string{
        $betweenCodeMain = $this->vars . $this->activeCode;
        $result = $this->importJson . $this->resultCode . CppBuilderHelper::setMainClass($betweenCodeMain);
        $this->reset();
        return $result;
    }
}