<?php


require 'conexao.banco.php';


//================================================================================================



//================================================================================================

$idCliente = "";
$nomeCliente ="";
$numeroOrcamento="";
$resultado=0;
$valorGeral=0;
$usuario ="";

if(isset($_POST['orcamentoPainel'])) {
    $numeroOrcamento = $_POST['orcamentoPainel'];
    $data = date('Y-m-d');
    $usuario = $_POST['usuario'];
        
    $sql = $pdo->prepare("INSERT INTO tb_log_delivery SET orcamento = :orcamento, dataa = :dataa, usuario = :usuario");
    $sql->bindValue(":dataa", $data);
    $sql->bindValue(":orcamento", $numeroOrcamento);
    $sql->bindValue(":usuario", $usuario);
    $sql->execute();   
    
    header("Location:/modelo.painel.2.php?orcamento=$numeroOrcamento");
    exit;

}