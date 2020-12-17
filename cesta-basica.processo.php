<?php
session_start();
require 'conexao.banco.php';

if(!empty($_SESSION['logado'])) {       
        
    $usuario = $_SESSION['logado'];           
    
}

//--------------------------------------ADICIONAR INFORMACAO----------------------------------------------------------------------

if(isset($_POST['data']) && empty($_POST['data']) == false) {

	$data = $_POST['data'];
    $responsavel = $_POST['responsavel'];
    $quantidade = $_POST['quantidade'];
    $valor = str_replace(",",".",$_POST['valor']);
    $tipoCesta = $_POST['tipoCesta'];
	$tipoPessoa = $_POST['tipoPessoa'];

	$sql = $pdo->prepare("INSERT INTO tb_cestabasica SET dataa = :dataa, responsavel = :responsavel, quantidade = :quantidade, valor = :valor, tipoCesta = :tipoCesta, tipoPessoa = :tipoPessoa, usuario = :usuario");
	$sql->bindValue(":dataa", $data);
    $sql->bindValue(":responsavel", $responsavel);
    $sql->bindValue(":quantidade", $quantidade);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":tipoCesta", $tipoCesta);
    $sql->bindValue(":tipoPessoa", $tipoPessoa);
    $sql->bindValue(":usuario", $usuario);
    $sql->execute();

    header("Location:/cesta-basica.painel.1.php");

    exit;

} else {

    header("Location:/cesta-basica.painel.1.php");

}



//------------------------------------------------------------------------------------------------------------


if(isset($_GET['id']) && empty($_GET['id']) == false) {
    $id = addslashes($_GET['id']);

    $sql = $pdo->prepare("DELETE FROM tb_cestabasica WHERE id = '$id'");
    $sql->execute();

    header("Location: cesta-basica.painel.1.php");

} else {
    
    header("Location: cesta-basica.painel.1.php");
}

?>
?>