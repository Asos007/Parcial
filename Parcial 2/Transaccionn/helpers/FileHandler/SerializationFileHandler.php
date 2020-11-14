<?php 

class SerializationFileHandler implements IFileHandler {

    public $directory;
    public $fileName;


    function __construct($fileName, $directory){
        $this->directory = $directory;
        $this->fileName = $fileName;
    }

    function CreateDirectory(){
        if(!file_exists($this->directory)){
            mkdir($this->directory,0777,true);
        }
    }

    function SaveFile($value){

        $this->CreateDirectory();

        $path = $this->directory.'/'.$this->fileName.'.txt';

        $serializeData = serialize($value);

        file_put_contents($path, $serializeData);

    }

    function ReadFile(){

        $this->CreateDirectory();

        $path = $this->directory.'/'.$this->fileName.'.txt';
        
        if(file_exists($path)){
            $contents = file_get_contents($path);
            return unserialize($contents);
        }else{
            return false;
        }

    }
    

}


?>