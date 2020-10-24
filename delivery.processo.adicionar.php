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

if(isset($_POST['id']) && empty($_POST['id']) == false) {
    $data = $_POST['data'];
    $cupom = $_POST['cupom']; 
    $valor = str_replace(",",".",$_POST['valor']);    
    $status = 'LIBERADO PARA ENTREGA';
    
   echo $data.";".$cupom.";".$valor.";".$status;

    /*$sql = $pdo->prepare("INSERT INTO tb_log_delivery SET dataa = :dataa, idCliente = :idCliente, idEndereco = :idEndereco, cupom = :cupom, compra = :compra, valor = :valor, statuss = :statuss");
    $sql->bindValue(":dataa", $data);
    $sql->bindValue(":idCliente", $idCliente);
    $sql->bindValue(":idEndereco", $idEndereco);    
    $sql->bindValue(":cupom", $cupom);
    $sql->bindValue(":compra", $compra);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":statuss", $status);
    $sql->execute();*/



    //header("Location:/delivery.painel.php");

    exit;

} else {

    //header("Location:/delivery.painel.php");

}


?>