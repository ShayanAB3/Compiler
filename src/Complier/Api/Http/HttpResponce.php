<?php

namespace User\ComposerTest\Complier\Api\Http;

class HttpResponce{
    public string $responce;
    public int $code;

    public function __construct(string $responce,int $code)
    {
        $this->responce = $responce;
        $this->code = $code;
    }

    public function getIsError():bool{
        return $this->code >= 400;
    }
    public function getExtensionCode(int $code){
        return $this->code == $code;
    }
    public function getResponce(): mixed{
        $responceJson = json_decode($this->responce);
        if($responceJson === NULL){
            return $this->responce;
        }
        return $responceJson;
    }
    
}