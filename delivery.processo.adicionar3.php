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



if(isset($_POST['cupom']) && empty($_POST['cupom']) == false) {
    $id = $_POST['id'];
    $data = $_POST['data'];
    $cupom = $_POST['cupom']; 
    $valor = str_replace(",",".",$_POST['valor']);    
    $status = 'LIBERADO PARA ENTREGA';
    //$dataLiberar = date('Y-m-d H:i');
    $dataLiberar = "";
    
   //echo $data.";".$cupom.";".$valor.";".$status;

    $sql = $pdo->prepare("UPDATE tb_log_delivery SET dataa = :dataa, cupom = :cupom, valor = :valor, statuss = :statuss, dataLiberar = NOW() WHERE id = $id");
    $sql->bindValue(":dataa", $data);
    $sql->bindValue(":cupom", $cupom);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":statuss", $status);
    //$sql->bindValue("dataLiberar", $dataLiberar);
    $sql->execute();

    header("Location:/delivery.painel.2.php");

    exit;

} else {


    
    header("Location:/delivery.painel.2.php");

}

?>