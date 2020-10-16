<?php
$dsn = "mysql:dbname=bd_produto;host=localhost";
$dbuser="root";
$dbpass="";

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
} catch (PDOException $e) {
    echo "Conexão com o banco de dados falhou: ".$e->getMessage();
}