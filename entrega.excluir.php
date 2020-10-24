<?php
session_start();
require 'conexao.banco.php';
require 'classes/usuarios.class.php';


if (isset($_SESSION['logado']) && empty($_SESSION['logado']) == false) {
} else {
    header("Location: login.php");
}

$usuarios = new Usuarios($pdo);
$usuarios->setUsuario($_SESSION['logado']);

if($usuarios->temPermissao('USUARIO') == false) {
    header("Location:index.php");
    exit;
}

if(isset($_GET['id']) && empty($_GET['id']) == false) {
    $id = addslashes($_GET['id']);

    $sql = $pdo->prepare("DELETE FROM tb_entrega WHERE id = '$id'");
    $sql->execute();

    header("Location: entrega.painel.php");

} else {
    
    header("Location: entrega.painel.php");
}

?>