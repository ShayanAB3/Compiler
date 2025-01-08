<?php

namespace User\ComposerTest\Helper\Main;

use Exception;
use User\ComposerTest\Config\LangProgConfig;
use User\ComposerTest\Config\PathConfigEnum;
use User\ComposerTest\Helper\Path\PathBuilder;

class FileCompiler{
    private $path;
    
    public function __construct(string $type){ 
        $this->path = self::getFileName($type);
    }
    public static function create(string $path,string $code){
        $codeFile = fopen($path, 'w');
        fwrite($codeFile, $code);
        fclose($codeFile);
    }
    public static function delete(string $path) : bool{
        if(self::isFile($path)){
            return unlink($path);   
        }
        return false;
    }
    public static function read(string $path) : string | false{
        if(self::isFile($path)){
            return file_get_contents($path);
        }
        return false;
    }

    public static function isFile(string $path) : bool{
        return is_file($path);
    }

    private static function getFileName(string $type) : string{
        $pathBuilder = new PathBuilder(PathConfigEnum::TestFilesCompiler);

        $folderLang = LangProgConfig::getLang($type)->getFolderCompiler();
        $fileName = $pathBuilder->getFileName(LangProgConfig::getLang($type)->getTypeFile());

        $pathBuilder->append([$folderLang,$fileName]);
        
        return $pathBuilder->getPath();
    }

    public function createOrDelete(callable $cb,string $code,array $input) : array{
        self::create($this->path,$code);
        list($output,$retval,$time) = CompilerHelper::getTimeCompiler($cb,$this->path,$input);
        self::delete($this->path);
        
        return [$output,$retval,$time];
    }
}