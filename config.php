<?php 

/*
      usaremos el constructor PDO
      necesita que le pasemos el host de la conexion a la base de datos
      el nombre de usuario de MYSQL
      el password
      y las opciones de conexion
 */



return [
  'db' => [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'tutorial_crud',
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  ]
];


    //se creo un array de configuracion
    //en el array db se definieron los parametros y opciones que usaremos para conectarnos a la bd
 
