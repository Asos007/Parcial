<?php
require_once '../layout/layout.php';
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

$layout = new Layout(true);

$service = new TransaccionServiceFile();
$utilities = new Utilities();


if (isset($_FILES['transaccionFile']) && $_FILES["transaccionFile"]["error"] == 0) {

    

    $file = $_FILES['transaccionFile'];
    $transaccionesImported = array();
    $transaccionesImported = $service->Import($file);

    
    if(!empty($transaccionesImported)){

        foreach ($transaccionesImported as $transaccionImported) {

            $service->Add($transaccionImported);

        }

    }

    header('Location: ../index.php'); 
    exit();
}

?>

<?php $layout->printHeader();?>

<div class="container my-5">
    <div>
        <a href="../" class="button is-primary is-medium">Volver</a>
    </div>

    <hr>

    <form action="import.php" method="POST" enctype="multipart/form-data">
        <div class="panel is-dark">
            
            <p class="panel-heading">
                Importar
            </p>

            <div class="px-5 py-5">
                
                <div class="file has-name py-5">
                    <label class="file-label">
                        <input class="file-input" type="file" name="transaccionFile"
                            accept="application/json, text/plain, application/vnd.ms-excel,.csv" id="import">
                        <span class="file-cta">
                            <span class="file-label">
                                Seleccione un archivo
                            </span>
                        </span>
                        <span class="file-name">
                        </span>
                    </label>
                </div>


                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-link">Importar</button>
                    </div>
                    <div class="control">
                        <a href="../index.php" class="button is-link is-light">Cancel</a>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function (e) {

        $inputFile = document.getElementById('import');
        $fileName = document.querySelector('.file-name');

        $inputFile.addEventListener('change', function () {

            var fileName = this.value.split('\\').pop();
            $fileName.innerText = fileName;

        })

    })
</script>
<?php $layout->printFooter()?>