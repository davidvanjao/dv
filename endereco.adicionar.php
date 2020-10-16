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

if($usuarios->temPermissao('PES') == false) {
    header("Location:index.php");
    exit;
}

if(isset($_POST['cep']) && empty($_POST['cep']) == false) {
	$cep = $_POST['cep'];
    $cidadeEstado = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $logradouro = $_POST['logradouro'];
    $nomeEdificio = $_POST['complemento'];                

    $sql = $pdo->prepare("INSERT INTO tb_endereco SET cep = :cep, cidadeEstado = :cidadeEstado, bairro = :bairro, logradouro = :logradouro, nomeEdificio = :nomeEdificio");
    $sql->bindValue(":cep", $cep);
    $sql->bindValue(":cidadeEstado", $cidadeEstado);
    $sql->bindValue(":bairro", $bairro);
    $sql->bindValue(":logradouro", $logradouro);
    $sql->bindValue(":nomeEdificio", $nomeEdificio);
    $sql->execute();

    header("Location:/endereco.painel.php");

    exit;

} else {

    header("Location:/endereco.painel.php");

}


?>