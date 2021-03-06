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

if($usuarios->temPermissao('ENT') == false) {
    header("Location:index.php");
    exit;
}


//========================================================================================================


//=================================================ADICIONAR==========================================================================

if(isset($_POST['data']) && empty($_POST['data']) == false) {
    $data = $_POST['data'];
	$cep = $_POST['cep'];
    $cidadeEstado = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $logradouro = $_POST['logradouro'];
    $valor = str_replace(",",".",$_POST['valor']);   
    $compra = $_POST['compra'];  
    $nCaixas = $_POST['quantidade'];             

    $sql = $pdo->prepare("INSERT INTO tb_entrega SET dataa = :dataa, cep = :cep, cidadeEstado = :cidadeEstado, bairro = :bairro, logradouro = :logradouro, valor = :valor, compra = :compra, nCaixas = :nCaixas");
    $sql->bindValue(":dataa", $data);
    $sql->bindValue(":cep", $cep);
    $sql->bindValue(":cidadeEstado", $cidadeEstado);
    $sql->bindValue(":bairro", $bairro);
    $sql->bindValue(":logradouro", $logradouro);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":compra", $compra);
    $sql->bindValue(":nCaixas", $nCaixas);
    $sql->execute();

    header("Location:/entrega.painel.1.php");

    exit;

} else {

    header("Location:/entrega.painel.1.php");

}

//=================================================EXCLUIR==========================================================================

if(isset($_GET['id']) && empty($_GET['id']) == false) {
    $id = addslashes($_GET['id']);

    $sql = $pdo->prepare("DELETE FROM tb_entrega WHERE id = '$id'");
    $sql->execute();

    header("Location: entrega.painel.1.php");

} else {
    
    header("Location: entrega.painel.1.php");
}

?>