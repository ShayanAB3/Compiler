<?php

namespace User\ComposerTest\Complier;

use User\ComposerTest\Executor\ExecutorResult;

interface ICompilers{
    /**
     * Компилирует и проверяет на ошибки
     * @param string $code
     * @param array $input
     * @return ExecutorResult
     */
    public function compile(string $code,array $input = []) : ExecutorResult;
    /**
     * Компилирует файл
     * @param string $path
     * @param array $input
     * @return ExecutorResult
     */
    public function compileFile(string $path,array $input = []) : ExecutorResult;

    public function getLang() : string;
}