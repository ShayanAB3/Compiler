<?php

namespace User\ComposerTest\Complier\Api\Http;

use Exception;
use User\ComposerTest\Complier\Api\Enum\HttpMethodEnum;
use User\ComposerTest\Helper\Main\ArrayHelper;

class HttpRequest{
    public readonly string $url;
    public readonly string $method;
    public string $body = "";
    public array $headers = [];

    private array $property = ["url","method","body","headers"];

    public function __construct(string $url,HttpMethodEnum $method){
        $this->setUrl($url);
        $this->setHttpMethod($method);
    }

    public function setUrl(string $url){
        $this->url = $url;
    }

    public function setHttpMethod(HttpMethodEnum $method){
        $this->method = $method->value;
    }

    public function setBody(array $body){
        $this->body = json_encode($body);
    }

    public function setHeaders(array $headers){
        $this->headers = $headers;
    }

    public function setOptions(array $params){
        if(!ArrayHelper::isAssociativeArray($params)){
            throw new Exception("Опций для настройки Api должен быть ассотивным массивом.");
        }
        foreach ($params as $key => $value) {
           if(ArrayHelper::searchArray($key,$this->property)){
                $this->$key = $value;
           }
        }
    }

    public function getOptionsToArray() : array{
        return (array)$this;
    }
}