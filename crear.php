<?php include 'funciones.php';
csrf();

if(isset($_POST['submit']) && !hash_equals($_SESSION['csrf'],$_POST['csrf'])) {
    die();
}

 ?>

<!-- Codigo PHP -->
<?php
       if(isset($_POST['submit'])){

        $resultado = [
            'error' => false,
            'mensaje' => 'El alumno ' .escapar($_POST['nombre']) . ' se ha agregado con exito'
        ];

        $config = include 'config.php';

        try{
             $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
             $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

             // Codigo que insertara el alumno
             $alumno = array(
                 "nombre" => $_POST['nombre'],
                 "apellido" => $_POST['apellido'],
                 "email" => $_POST['email'],
                 "edad" => $_POST['edad'],
             );

             // Codigo que implementa la consulta
             $consultaSQL = "INSERT INTO alumnos(nombre,apellido,email,edad)";
             $consultaSQL .= "values (:" . implode(", :", array_keys($alumno)) . ")";


             //metodo prepare y a ejecutar la consulta
             $sentencia = $conexion->prepare($consultaSQL);
             $sentencia->execute($alumno);

        } catch(PDOException $error){
             $resultado['error'] = true;
             $resultado['mensaje'] = $error->getMessage();
        }
       }
?>




<?php include "templates/header.php"; ?>

<?php 
// Mensaje de confirmacion
if(isset($resultado)) { 
    ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
                <?= $resultado['mensaje'] ?>
            </div>
            </div>
        </div>
    </div>
<?php
}
?>





<!-- formulario para AGREGAR un alumno
 se ha agregado un enlace en index.php para acceder a esta ruta
no se especifica ninguna accion en el formulario por lo que se enviara a la misma pagina en la que esta definida
-->

<div class="container">
<div class="row">
<div class="col-md-12">
    <h2 class="mt-4">Crea un alumno</h2>
    <hr>
    <form method="post">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control"> 
        </div>
        <div class="form-group">
           <label for="apellido">Apellido</label>
           <input type="text" name="apellido" id="apellido" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="edad">Edad</label>
            <input type="text" name="edad" id="edad" class="form-control">
        </div>
        <br>
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
            <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
    </form>
</div>
</div>
</div>



<?php include "templates/footer.php"; ?>