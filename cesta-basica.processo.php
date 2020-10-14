<?php

require 'conexao.php';
require 'cesta-basica.php';


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

if(isset($_POST['data']) && empty($_POST['data']) == false) {
	$data = $_POST['data'];
    $responsavel = $_POST['responsavel'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $tipoCesta = $_POST['tipoCesta'];
	$tipoPessoa = $_POST['tipoPessoa'];

	$sql = $pdo->prepare("INSERT INTO tb_cestabasica SET dataa = :dataa, responsavel = :responsavel, quantidade = :quantidade, valor = :valor, tipoCesta = :tipoCesta, tipoPessoa = :tipoPessoa");
	$sql->bindValue(":dataa", $data);
    $sql->bindValue(":responsavel", $responsavel);
    $sql->bindValue(":quantidade", $quantidade);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":tipoCesta", $tipoCesta);
	$sql->bindValue(":tipoPessoa", $tipoPessoa);
    $sql->execute();
    
    header("Location:cesta-basica.php");
    exit;
	
}

?>