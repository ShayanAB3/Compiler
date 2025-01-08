<?php

namespace User\ComposerTest\Executor;

/**
 * @method string getCode()
 * @method string getOutput()
 * @method bool getIsError()
 * @method float getTime
 */

class ExecutorResult{
    protected string $code;
    protected string $output;
    protected bool $isError;
    protected string $status;
    protected string $lang;
    protected float $time = 0;

    public function __construct(string $code,string $output,bool $isError,string $lang,float $time = 0)
    { 
        $this->code = $code;
        $this->output = $output;
        $this->isError = $isError;
        $this->status = $this->getStatus();
        $this->lang = $lang;
        $this->setTime($time);
    }

    public function setTime(float $time){
        $this->time = round($time,2);
    }

    public function __call(string $methodName,array $arg){
        $method = lcfirst(str_replace("get","",$methodName));
        return $this->$method;
    }

    public function getStatus() : string{
        return $this->isError ? "Error" : "Success";
    }
    public function getResultCode() : mixed{
        $decodeJSON = json_decode($this->output);
        if($this->isError){
            return "Error: ". $this->output;
        }
        if($decodeJSON === NULL){
            return $this->output;
        }
        return $decodeJSON;
    }
    public function getAllExecutorResult():array{
        return [$this->code,$this->output,$this->isError];
    }
    public function getIsExpect(mixed $expect = null): bool{
        return $expect === $this->getResultCode();
    }

}