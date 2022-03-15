<?php
// Para evitar ataque XSS se codificaran los caracteres especiales en sus respectivas versions HTML
// Se creara una funcion reutilizable

function escapar($html){
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

// Vamos a agregar proteccion contra ataques CSRF
// Esta clase de ataques consiste en engañar al navegador y ejecutar codigo no deseado
// Almacenare un token CSRF en una variable de sesion del servidor
function csrf() {

    session_start();

    if(empty($_SESSION['csrf'])) {
 
        if(function_exists('random_bytes')) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        } else if(function_exists('mcrypt_create_iv')) {
            $_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        } else {
            $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }
}
?>