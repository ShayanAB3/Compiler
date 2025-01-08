<?php

namespace User\ComposerTest\Helper\Main;

class CompilerHelper{
    public static function getTimeCompiler(callable $cb,string $path,array $input) : array{
        $input = implode(" ",$input);
        $startTime = microtime(true);
        list($output,$retval) = $cb($path,$input);
        $endTime = microtime(true);
        $time = $endTime - $startTime;
        return [implode($output),(bool)$retval,$time];
    }
}