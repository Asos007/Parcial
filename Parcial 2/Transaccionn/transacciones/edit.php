<?php
require_once '../helpers/utilities.php';
require_once '../layout/layout.php';
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

if (isset($_GET['id'])) {

    $transaccionId = $_GET['id'];
    $transaccion = $service->GetById($transaccionId);

    if (isset($_POST['monto']) && isset($_POST['description'])) {


        $transaccionUpdated = new Transaccion();

        $transaccionUpdated->InitializeData(
            $transaccionId,
            $_POST['monto'],
            $_POST['description'],
            $transaccion->date,
            $transaccion->time
        );

        $service->Update($transaccionId, $transaccionUpdated);

        header('Location: ../index.php'); 
        exit();

    }

} else {

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

    <form action="edit.php?id=<?php echo $transaccion->id; ?>" method="POST">
        <div class="panel is-dark">
            
            <p class="panel-heading">
                Editar Transaccion
            </p>

            <div class="px-5 py-5">

                <
                <div class="field">
                    <label class="label">Monto:</label>
                    <div class="control">
                        <input class="input" type="number" value="<?php echo $transaccion->monto; ?>"
                            placeholder="Ingrese monto" name="monto" required>
                    </div>
                </div>

                
                <div class="field">
                    <label class="label">Fecha:</label>
                    <div class="control">
                        <input class="input" type="date" value="<?php echo $transaccion->date; ?>"
                            pattern="\d{2}-\d{2}-\d{4}" disabled>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Horario:</label>
                    <div class="control">
                        <input class="input" type="time" value="<?php echo $transaccion->time; ?>" disabled>
                    </div>
                </div>

                
                <div class="field">
                    <label class="label">Descripci&oacute;n (Opcional):</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="Ingrese Mensaje"
                            name="description"><?php echo $transaccion->description; ?></textarea>
                    </div>
                </div>


                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-link">Actualizar</button>
                    </div>
                    <div class="control">
                        <a href="../index.php" class="button is-link is-light">Cancel</a>
                    </div>
                </div>
            </div>

        </div>
    </form>

</div>
<?php $layout->printFooter()?>