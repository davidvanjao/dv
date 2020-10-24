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

if(isset($_POST['idEndereco']) && empty($_POST['idEndereco']) == false) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
	$idEndereco = $_POST['idEndereco'];
    $numero = $_POST['numero'];           

    $sql = $pdo->prepare("INSERT INTO tb_cliente SET nome = :nome, idEndereco = :idEndereco, numero = :numero, telefone = :telefone");
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":telefone", $telefone);
    $sql->bindValue(":idEndereco", $idEndereco);
    $sql->bindValue(":numero", $numero);
    $sql->execute();

    header("Location:/cliente.painel.php");

    exit;

} else {

    header("Location:/cliente.painel.php");

}


?>