<?php

namespace User\ComposerTest\Complier\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use User\ComposerTest\Complier\Api\Http\HttpRequest;
use User\ComposerTest\Complier\Api\Http\HttpResponce;
use User\ComposerTest\Complier\ICompilers;
use User\ComposerTest\Executor\ExecutorResult;
use User\ComposerTest\Helper\Main\FileCompiler;

abstract class ApiCompiler implements ICompilers{
    protected string $code = "";
    protected array $input = [];
    protected string $lang = "";

    abstract public function options() : HttpRequest;
    abstract public function execute(HttpResponce $response) : ExecutorResult;
    
    public function __construct(string $lang){
        $this->lang = $lang;
    }

    protected function request() : HttpResponce{
        $options = $this->options();
    
        try {
            $client = new Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
            $response = $client->request($options->method, $options->url,
            ["body" => $options->body,
            "headers" => $options->headers]);
            $body = $response->getBody()->__toString();
            $statusCode = $response->getStatusCode();
        } catch (ClientException $client) {
            $response = $client->getResponse();
            $body = $response->getBody();
            $statusCode = $response->getStatusCode();
        } catch (ConnectException $connect){
            $body = $connect->getMessage();
            $statusCode = 400;         
        }
        return new HttpResponce($body,$statusCode);
    }
    public function compile(string $code,array $input = []) : ExecutorResult{
        $this->code = $code;
        $this->input = $input;
        $response = $this->request();
        return $this->execute($response);
    }
    public function compileFile(string $path,array $input = []): ExecutorResult{
        $this->code = FileCompiler::read($path);
        $this->input = $input;
        $response = $this->request();
        return $this->execute($response);
    }

    public function setLang(string $lang){
        $this->lang = $lang;
    }
    public function getLang() : string{
        return $this->lang;
    }
}