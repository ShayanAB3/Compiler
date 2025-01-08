<?php


namespace User\ComposerTest\Helper\Python;

class PythonBuilderHelper{
    public static function formatCode(string $code, int $indentSize = 0) : string{
        $lines = explode("\n", trim($code));
        $formattedCode = '';
        foreach ($lines as $line) {
            $formattedLine = str_repeat(' ', $indentSize) . $line;
            $formattedCode .= $formattedLine . "\n";
        }
        return trim($formattedCode);
    }
}