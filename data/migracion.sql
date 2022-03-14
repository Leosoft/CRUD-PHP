/*
Script que crea la base de datos llama tutorial_crud
use se utiliza para seleccionar la base de datos
luego se crea la tabla alumnos con sus campos 


se le agregan los campos de created_at y updated_at 
el primero es para registrar la fecha de creacion
el segundo para su actualizacion
se le asigna la fecha actual con la sentencia DEFAULT y el valor CURRENT_TIMESTAMP

*/

CREATE DATABASE tutorial_crud;

use tutorial_crud;

CREATE TABLE alumnos (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    apellido VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    edad INT(3),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/* ejecutado este script en workbench 8.0 */