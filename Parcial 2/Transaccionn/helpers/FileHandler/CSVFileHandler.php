<?php

class CSVFileHandler implements IFileHandler
{

    public $directory;
    public $fileName;
    public $extension;

    public function __construct($fileName, $directory)
    {
        $this->directory = $directory;
        $this->fileName = $fileName;
    }

    public function CreateDirectory()
    {
        if (!file_exists($this->directory)) {
            mkdir($this->directory, 0777, true);
        }
    }

    public function SaveFile($value)
    {

        $this->CreateDirectory();

        $path = $this->directory . '/' . $this->fileName . '.csv';

        $file = fopen($path, 'w+');

        if(!empty($value)){

            foreach ($value as $object) {
                fputcsv($file, get_object_vars($object));
            }

            fclose($file);

        }

    }

    public function ReadFile()
    {

        $this->CreateDirectory();

        $path = $this->directory . '/' . $this->fileName . '.csv';

        if (file_exists($path)) {

            $file = fopen($path, "r");

            $csvDecodeCon = array();

            if ($file !== false) { 

                $csv = file_get_contents($path);

                $csvDecodeSin = array_map('str_getcsv', explode("\n", $csv));
                $header = array_keys((new Transaccion())->get());

                foreach ($csvDecodeSin as $value) {
                    $csvDecodeSin  = $this->array_replace_keys($value, $header );

                    if(!empty($csvDecodeSin) || count($csvDecodeSin) > 1){
                        array_push($csvDecodeCon, $csvDecodeSin);
                    }
                    
                } 

                array_pop($csvDecodeCon);

            }

            return $csvDecodeCon;

        } else {

            return false;

        }

    }

    private function array_replace_keys($array, $keys)
    {
        foreach ($keys as $search => $replace) {
            if ( isset($array[$search])) {
                $array[$replace] = $array[$search];
                unset($array[$search]);
            }
        }

        return (object)$array;
    }


}