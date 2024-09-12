<?php

require_once("config.php");

date_default_timezone_set('America/Sao_Paulo');

try {
$pdo = new PDO("mysql:dbname=$banco;host=$servidor","$usuario", "$senha");
} catch (Exception $e) {
    echo "Erro ao tentar conectar com o banco de dados <br> <br>" .$e;
}

?>
