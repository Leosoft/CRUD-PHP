<!--CRUD con PHP y MYSQL -->

<!-- 
    directorio raiz del CRUD
-->

<?php
// READ 
//incluimos las funciones 
// Primero debemos obtener la lista de alumnos desde la base de datos
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}


$error = false;
$config = include 'config.php';

//conexion a la base de datos a traves de un bloque try-catch
//si hay error se almacena en la variable $error
try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    // El formulario enviara el apellido del alumno que introduzcamos a la propia pagina, por lo que debemos agregar una consulta SQL
// alternativa que se ejecute cuando el formulario se haya enviado

if (isset($_POST['apellido'])) {
    $consultaSQL = "SELECT * FROM alumnos WHERE apellido LIKE '%" . $_POST['apellido'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM alumnos";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumnos = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['apellido']) ? 'Lista de alumnos (' . $_POST['apellido'] . ')' : 'Lista de alumnos';
?>

<?php include "templates/header.php"; ?>

<!-- Mostrar error si se produce -->
<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<!-- ENLACE A crear.php -->

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="crear.php"  class="btn btn-primary mt-4">Crear alumno</a>
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="apellido" name="apellido" placeholder="Buscar por apellido" class="form-control">
        </div>
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
        <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
      </form>
    </div>
  </div>
</div>

<!-- Tabla para mostrar alumnos --> 
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Edad</th>
            <th>Acciones</th>
          </tr>
        </thead>

                 <tbody>
                     <?php 
                     // Se comprueba con el metodo rowCount que existen alumnos
                     // recorre la lista de alumnos y agrega filas a la tabla por cada uno de los alumnos
                     if ($alumnos && $sentencia->rowCount() > 0) {
                        foreach ($alumnos as $fila) {
                          ?>
                          <tr>
                            <td><?php echo escapar($fila["id"]); ?></td>
                            <td><?php echo escapar($fila["nombre"]); ?></td>
                            <td><?php echo escapar($fila["apellido"]); ?></td>
                            <td><?php echo escapar($fila["email"]); ?></td>
                            <td><?php echo escapar($fila["edad"]); ?></td>
                            <td>
                              <a href="<?= 'borrar.php?id=' . escapar($fila["id"]) ?>">🗑️Borrar</a>
                              <a href="<?= 'editar.php?id=' . escapar($fila["id"]) ?>">✏️Editar</a>
                            </td>
                          </tr>
                          <?php
                        }
                      }
                      ?>
                    <tbody>
                  </table>
                </div>
              </div>
            </div>
            
            <?php include "templates/footer.php"; ?>