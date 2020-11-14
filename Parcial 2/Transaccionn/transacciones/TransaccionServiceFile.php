<?php

class TransaccionServiceFile implements IServiceBase
{

    
    private $utilities;

    private $fileHandler;
    private $fileName;
    private $directory;
    private $log;

    
    public function __construct($directory = "data")
    {
        $this->utilities = new Utilities();
        $this->fileName = "transacciones";
        $this->directory = $directory;
        $this->fileHandler = new CSVFileHandler($this->fileName, $this->directory);
        $this->log = new Log('transaccion','../log/');
    }

    
    public function GetList()
    {

        $transaccionesDecode = $this->fileHandler->ReadFile();

        $transacciones = array();

        if ($transaccionesDecode == false) {

            $fileHandler = $this->fileHandler->SaveFile($transacciones);

        } else {

            foreach ($transaccionesDecode as $transaccionDecode) {

                $transaccion = new Transaccion();

                $transaccion->set($transaccionDecode);

                array_push($transacciones, $transaccion);

            }
            
        }

        return $transacciones;
    }


    
    public function GetById($id)
    {

        $transacciones = $this->GetList();

        $transaccion = $this->utilities->filterByProperty($transacciones, 'id', $id)[0];

        return $transaccion;

    }

    
    public function Add($transaccion)
    {

        $transacciones = $this->GetList();
        $transaccionId = 1;

        if (!empty($transaccion)) {
            $lastElement = $this->utilities->getLastArrayElement($transacciones);
            $transaccionId = $lastElement->id + 1;
        }

        $transaccion->id = $transaccionId;
        
        array_push($transacciones, $transaccion);

        $this->fileHandler->SaveFile($transacciones);

        
        $this->log->agregar('Se agrego transaccion id['.$transaccion->id.']');
    }

    
    public function Delete($id)
    {

        $transacciones = $this->GetList();

        $indexToDelete = $this->utilities->searchIndexElement($transacciones, 'id', $id);

        unset($transacciones[$indexToDelete]);

        $transacciones = array_values($transacciones);

        $this->fileHandler->SaveFile($transacciones);

        
        $this->log->agregar('Se Borro la transaccion id['.$id.']');
    }

    
    public function Update($id, $transaccion)
    {
        $transaccionToUpdate = $this->GetById($id);

        $transacciones = $this->GetList();

        $indexToUpdate = $this->utilities->searchIndexElement($transacciones, 'id', $id);

        $transacciones[$indexToUpdate] = $transaccion;

        $this->fileHandler->SaveFile($transacciones);

        
        $this->log->agregar('Se Actualizo la transaccion id['.$id.']');

    }

    public function Import($file, $directory='tmp'){


        $tmpName = $file['tmp_name'];
        $fileName = $file['name'];

        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $name = pathinfo($fileName, PATHINFO_FILENAME);


        
        if($extension == 'json' || $extension == 'csv' || $extension == 'txt'){

            $fileHandler = null;
            $results = array();

            
            switch ($extension) {

                case 'json':
                    $fileHandler = new JsonFileHandler($name, $directory);
                    $fileHandler->CreateDirectory();
                    break;

                case 'csv':
                    $fileHandler = new CSVFileHandler($name, $directory);
                    $fileHandler->CreateDirectory();
                    break;

            }

            if($fileHandler !== null){

                
                if(move_uploaded_file($tmpName, $directory.'/'.$fileName)){
                    $results = $fileHandler->ReadFile();
                }
            
            }

        }

        return $results;

    }



}