<?php
session_start();
require 'conexao.php';
require 'classes/usuarios.class.php';


if (isset($_SESSION['logado']) && empty($_SESSION['logado']) == false) {
} else {
    header("Location: login.php");
}

$usuarios = new Usuarios($pdo);
$usuarios->setUsuario($_SESSION['logado']);

if($usuarios->temPermissao('PES') == false) {
    header("Location:index.php");
    exit;
}

if(isset($_GET['id']) && empty($_GET['id']) == false) {
    $id = addslashes($_GET['id']);

    $sql = $pdo->prepare("DELETE FROM tb_cestabasica WHERE id = '$id'");
    $sql->execute();

    header("Location: cesta-basica.php");

} else {
    
    header("Location: cesta-basica.php");
}

?>