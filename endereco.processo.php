<?php
session_start();
require 'conexao.banco.php';
require 'classes/usuarios.class.php';


//===========================================ADICIONAR=====================================================

if(isset($_POST['cep']) && empty($_POST['cep']) == false) {
	$cep = $_POST['cep'];
    $cidadeEstado = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $logradouro = $_POST['logradouro'];
    $nomeEdificio = $_POST['complemento'];         
    $regiao = $_POST['regiao'];         

    $sql = $pdo->prepare("INSERT INTO tb_endereco SET cep = :cep, cidadeEstado = :cidadeEstado, bairro = :bairro, logradouro = :logradouro, nomeEdificio = :nomeEdificio, regiao = :regiao");
    $sql->bindValue(":cep", $cep);
    $sql->bindValue(":cidadeEstado", $cidadeEstado);
    $sql->bindValue(":bairro", $bairro);
    $sql->bindValue(":logradouro", $logradouro);
    $sql->bindValue(":nomeEdificio", $nomeEdificio);
    $sql->bindValue(":regiao", $regiao);
    $sql->execute();

    header("Location:/endereco.painel.1.php");

    exit;

} else {

    header("Location:/endereco.painel.1.php");

}


//===========================================EXCLUIR=====================================================

if(isset($_GET['id']) && empty($_GET['id']) == false) {
    $id = addslashes($_GET['id']);

    $sql = $pdo->prepare("DELETE FROM tb_endereco WHERE id = '$id'");
    $sql->execute();

    header("Location: endereco.painel.1.php");

} else {
    
    header("Location: endereco.painel.1.php");
}

?>