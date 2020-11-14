<?php

    class Log 
    {
        private $utilities = null;

        public function __construct($fileName, $directory){

            $this->fileName = $fileName;
            $this->directory = $directory;
            $this->utilities = new Utilities();

        }


        public function agregar($text){

            
            if (!file_exists($this->directory)) {

                mkdir($this->directory, 0777, true); 
            }

            $path = $this->directory . $this->fileName.'.log';

            
            
            $dateNow = $this->utilities->getCurrentDateTime('Y-m-d H:i:s'); 

            file_put_contents($path, 'Log: '.$dateNow.' INFO - '.$text.PHP_EOL, FILE_APPEND | LOCK_EX);

        }
        
    }
    

?>