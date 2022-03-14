<?php
// Para evitar ataque XSS se codificaran los caracteres especiales en sus respectivas versions HTML
// Se creara una funcion reutilizable

function escapar($html){
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
?>