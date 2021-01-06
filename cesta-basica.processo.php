<?php
session_start();
require 'conexao.banco.php';

if(!empty($_SESSION['logado'])) {       
        
    $usuario = $_SESSION['logado'];           
    
}

//--------------------------------------ADICIONAR INFORMACAO----------------------------------------------------------------------

if(isset($_POST['data']) && empty($_POST['data']) == false) {

	$data = addslashes($_POST['data']);
    $responsavel = addslashes($_POST['responsavel']);
    $quantidade = addslashes($_POST['quantidade']);
    $valor = addslashes(str_replace(",",".",$_POST['valor']));
    $tipocesta = addslashes($_POST['tipocesta']);
	$tipopessoa = addslashes($_POST['tipopessoa']);

	$sql = $pdo->prepare("INSERT INTO tb_cestabasica SET data_criacao = :data_criacao, responsavel = :responsavel,
    quantidade = :quantidade, valor = :valor, tipocesta = :tipocesta, tipopessoa = :tipopessoa, usuario = :usuario, data_entrada = NOW()");

	$sql->bindValue(":data_criacao", $data);
    $sql->bindValue(":responsavel", $responsavel);
    $sql->bindValue(":quantidade", $quantidade);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":tipocesta", $tipocesta);
    $sql->bindValue(":tipopessoa", $tipopessoa);
    $sql->bindValue(":usuario", $usuario);
    $sql->execute();

    header("Location:/index.php?p=cesta-basica1");

    exit;

} else {

    header("Location:/index.php?p=cesta-basica1");


}

//-----------------------------------------APAGAR INFORMACAO-------------------------------------------------------------------


if(isset($_GET['idcesta']) && empty($_GET['idcesta']) == false) {
    $id = addslashes($_GET['idcesta']);

    $sql = $pdo->prepare("DELETE FROM tb_cestabasica WHERE id = '$id'");
    $sql->execute();

    header("Location:/index.php?p=cesta-basica1");

    exit;    

} else {
    
    header("Location:/index.php?p=cesta-basica1");

}

?>