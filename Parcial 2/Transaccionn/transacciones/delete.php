<?php
require_once '../helpers/utilities.php';
require_once './transaccion.php';
require_once '../services/IServiceBase.php';
require_once './TransaccionServiceCookie.php';
require_once '../helpers/FileHandler/IFileHandler.php';
require_once '../helpers/FileHandler/JsonFileHandler.php';
require_once '../helpers/FileHandler/SerializationFileHandler.php';
require_once '../helpers/FileHandler/CSVFileHandler.php';
require_once './TransaccionServiceFile.php';
require_once './log.php';

$service = new TransaccionServiceFile();

if (isset($_GET['id'])) {

    $transaccionId = $_GET['id'];

    $service->Delete($transaccionId);

}

header('Location: ../index.php');
exit();