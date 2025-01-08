<?php

namespace User\ComposerTest\Helper\Path;

use User\ComposerTest\Config\PathConfigEnum;

class PathBuilder{
    private string $path = __DIR__."/../../";
    
    public function __construct(PathConfigEnum $path){
        $this->path .= $path->value;
    }

    public function checkFilePath() : bool{
        return file_exists($this->path);
    }

    public function checkFolderPath() : bool{
        return is_dir($this->path);
    }

    public function append(array | string $path){
        if(gettype($path) == "string"){
            $this->path .= $path;
            return;
        }
        foreach ($path as $key => $value) {
            $this->path .= "/".$value;   
        }
    }
    public function getFileName(string $fileType,string $fileName = null) : string{
        if($fileName == null){
            $fileName = hash("sha256","index");
            return $fileName.$fileType;
        }
        return $fileName.$fileType;
    }

    public function reset(){
        $this->path = __DIR__."/../../";
    }

    public function getPath() : string{
        $path = $this->path;
        $this->reset();
        return $path;
    }
}