<?php
namespace User\ComposerTest\Complier\Local;

use User\ComposerTest\Complier\ICompilers;
use User\ComposerTest\Executor\ExecutorResult;
use User\ComposerTest\Helper\Main\CompilerHelper;
use User\ComposerTest\Helper\Main\FileCompiler;

abstract class Compiler implements ICompilers{
    /**
     * Дает язык на котором мы работаем
     * @return string
     */
    abstract public function getLang():string;
    /**
     * Выполняет компиляцию языка программирование
     * @param string $path
     * @param string $input
     * @return array
     */
    abstract public function execute(string $path,string $input) : array;
     /**
     * Компилирует и проверяет на ошибки
     * @param string $code
     * @param array $input
     * @return ExecutorResult
     */
    public function compile(string $code,array $input = []) : ExecutorResult{
        $fileCompiler = new FileCompiler($this->getLang());
        list($output,$retval,$time) = $fileCompiler->createOrDelete(function(string $path,string $input){
            return $this->execute($path,$input);
        },$code,$input);

        return new ExecutorResult($code,$output,$retval,$this->getLang(),$time);
    }
    /**
     * Компилирует файл
     * @param string $path
     * @param array $input
     * @return ExecutorResult
     */
    public function compileFile(string $path,array $input = []) : ExecutorResult{
        list($output,$retval,$time) = CompilerHelper::getTimeCompiler(function(string $path, string $input){
            return $this->execute($path,$input);
        },$path,$input);
        
        $code = FileCompiler::read($path);

        return new ExecutorResult($code,$output,$retval,$this->getLang(),$time);
    }
}