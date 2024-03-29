<?php
//Primero necesitamos obtener los datos de los alumnos para su edicion
// Primero incluyo el archivo funciones.php y el array de configruaciones
// luego compruebo si el parametro $_GET['id'] este presente y que muestre un error en caso contrario
// Luego me conecto a la bd para buscar el alumno que estamos editando

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include 'config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El alumno no existe';
}

// Verificar si el parametro POST[submit] esta presente para conectarnos a la bd y actualizar el alumno
if (isset($_POST['submit'])) {
    try {
      $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
      $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
  // actualizacion de alumno
      $alumno = [
        "id"        => $_GET['id'],
        "nombre"    => $_POST['nombre'],
        "apellido"  => $_POST['apellido'],
        "email"     => $_POST['email'],
        "edad"      => $_POST['edad']
      ];

    // Actualizo el campo updated_at con la fecha actual
    // que obtenemos mediante la funcion NOW() de MYSQL
    $consultaSQL = "UPDATE alumnos SET
        nombre = :nombre,
        apellido = :apellido,
        email = :email,
        edad = :edad,
        updated_at = NOW()
        WHERE id = :id";
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($alumno);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
      
    $id = $_GET['id'];
    $consultaSQL = "SELECT * FROM alumnos WHERE id =" . $id;
  
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
  
    $alumno = $sentencia->fetch(PDO::FETCH_ASSOC);
  
    if (!$alumno) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado el alumno';
    }
  
  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
  ?>





<?php require "templates/header.php"; ?>






<?php
//Mostramos un error si ocurrio alguno
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>



<?php
// En caso de que se haya enviado el formulario
// Tendremos que mostrar tambien un mensaje de confirmacion
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El alumno ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>


<!-- Codigo del formulario --> 

<?php
if (isset($alumno) && $alumno) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el alumno <?= escapar($alumno['nombre']) . ' ' . escapar($alumno['apellido'])  ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= escapar($alumno['nombre']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="<?= escapar($alumno['apellido']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= escapar($alumno['email']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="edad">Edad</label>
            <input type="text" name="edad" id="edad" value="<?= escapar($alumno['edad']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "templates/footer.php"; ?>