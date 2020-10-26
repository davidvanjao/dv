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

    $sql = "SELECT a.id, a.dataa, b.nome, c.cidadeEstado, c.logradouro, b.numero, a.statuss
    from tb_log_delivery as a join tb_cliente as b join tb_endereco as c 
    on a.idCliente = b.id 
    and b.idEndereco = c.id
    where a.id = '$id'";

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {

        $log = $sql->fetch();
        
        $status = 'SAIU PARA ENTREGA';
        $data = date('Y-m-d');
        $dataEntregar = date('Y-m-d H:i');
            
        //echo $data.";".$idCliente.";".$idEndereco.";".$status;
    
        $sql = $pdo->prepare("UPDATE tb_log_delivery SET dataa = :dataa, statuss = :statuss, dataEntregar = :dataEntregar WHERE id = $id");
        $sql->bindValue(":dataa", $data);
        $sql->bindValue(":statuss", $status);
        $sql->bindValue(":dataEntregar", $dataEntregar);
        $sql->execute();
    
        header("Location:/delivery.painel.4.php");
    
        exit;
        
    }



} 

?>