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
    $id = $_GET['id'];
    $status = 'EM ANDAMENTO';
    //$dataIniciar = date('Y-m-d H:i');
    $dataIniciar = "";
    
   //echo $data.";".$idCliente.";".$idEndereco.";".$status;

    $sql = $pdo->prepare("UPDATE tb_log_delivery SET statuss = :statuss, dataIniciar = NOW() WHERE id = $id");
    $sql->bindValue(":statuss", $status);
    //$sql->bindValue(":dataIniciar", $dataIniciar);
    $sql->execute();



    header("Location:/delivery.painel.2.php");

    exit;

} else {

    header("Location:/delivery.painel.2.php");

}


?>