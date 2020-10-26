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


$id = 0;

if(isset($_GET['id']) && empty($_GET['id']) == false) {
    $id = addslashes($_GET['id']);

    $sql = "SELECT b.id, b.idEndereco, b.nome, b.telefone, c.cidadeEstado, c.logradouro, c.bairro, b.numero
    from tb_cliente as b join tb_endereco as c 
    on b.idEndereco = c.id
    where b.id = '$id'";

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {

        $cliente = $sql->fetch();
        
        $data = date('Y-m-d');
        $idCliente = $cliente['id'];
        $idEndereco = $cliente['idEndereco'];
        $compra = "1";
        $status = 'PEDIDO REALIZADO';
        $dataPedido = date('Y-m-d H:i');
            
        //echo $data.";".$idCliente.";".$idEndereco.";".$status;
    
        $sql = $pdo->prepare("INSERT INTO tb_log_delivery SET dataa = :dataa, idCliente = :idCliente, idEndereco = :idEndereco, compra = :compra, statuss = :statuss, dataPedido = :dataPedido");
        $sql->bindValue(":dataa", $data);
        $sql->bindValue(":idCliente", $idCliente);
        $sql->bindValue(":idEndereco", $idEndereco);    
        $sql->bindValue(":compra", $compra);
        $sql->bindValue(":statuss", $status);
        $sql->bindValue(":dataPedido", $dataPedido);
        $sql->execute();
    
        header("Location:/delivery.painel.1.php");
    
        exit;
        
    }



} 

?>