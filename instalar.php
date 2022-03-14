<!-- se crea el archivo instalar.php
en su interior se incluye el array de configuracion y se le asigna
una nueva instancia de la clase PDO a una variable a la que llamaremos $conexion
-->


<?php
//el metodo file_get_contents se utiliza para transmitir el contenido de un fichero a una cadena
$config = include 'config.php';

try{
    $conexion = new PDO('mysql:host=' . $config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    $sql = file_get_contents('data/migracion.sql');

    $conexion->exec($sql);
    echo "La base de datos y la tabla de alumnos se han creado con exito.";

} catch(PDOException $error){
    echo $error->getMessage();
}

//localhost/proyecto/instalar.php es la ruta para ejecutar e instalar la base de datos

?>