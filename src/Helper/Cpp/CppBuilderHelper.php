<?php

namespace User\ComposerTest\Helper\Cpp;

use Exception;
use User\ComposerTest\Helper\Main\ArrayHelper;

class CppBuilderHelper{
    const typeVarCppCode = [
        "string" => "std::string",
        "integer" => "int",
        "boolean" => "bool",
        "double" => "double",
    ];

    private static function getTypeVar(mixed $type) : string{
        switch (gettype($type)) {
            case "array":
                return self::getTypeVarArray($type);
                break;
            default:
                if(!array_key_exists(gettype($type), self::typeVarCppCode)){
                    throw new Exception("Извините данный тип для нас не известен");
                }
                return self::typeVarCppCode[gettype($type)];
            break;
        }
    }

    private static function getValueVar(mixed $value) : string{
        switch (gettype($value)) {
            case "array":
                if(ArrayHelper::isAssociativeArray($value)){
                    $value = array_values($value);
                }
                $jsonWithoutBrackets = trim(json_encode($value),"[]{}");
                return "{".$jsonWithoutBrackets."}";
            break;
            case "string":
                return '"'.$value.'"';
            break;
            default:
                return "$value";
            break;
        }
    }

    private static function getTypeVarArray(array $array) : string{
        $exceptType = gettype(array_shift($array));
        foreach($array as $key => $value){
            if($exceptType !== gettype($value)){
                throw new Exception("Данный массив имеет другой тип данных");
            }
        }
        $type = self::getTypeVar($exceptType);
        return $type."[]";
    }
    public static function getVarToString(array $array) : string{
        $result = "";
        foreach($array as $key => $value){
            $result .= "\n      ".self::getTypeVar($value). " $key = ". self::getValueVar($value).";";  
        }
        return $result;
    }

    public static function setMainClass(string $betweenCode = "") : string{
        $startMainClass = "\nint main() {\n ";
        $endMainClass = "\n}";
        return $startMainClass . $betweenCode . $endMainClass;
    }
}