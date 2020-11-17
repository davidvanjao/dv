<?php

session_start();

require 'conexao.banco.php';

if(isset($_GET['excluir'])) {

    $idProduto = (int)$_GET['excluir'];
     
    //echo $idProduto;
    //var_dump($_SESSION);

    
    if(isset($_SESSION['lista'])){

        unset($_SESSION['lista'][$idProduto]);

        header("Location:/modelo.painel.2.php");
        
    }else{
        echo "Nao deu certo!";
    }


}


if(isset($_GET['orcamentoPainelExcluir'])) {

    $numeroOrcamento = $_GET['orcamentoPainelExcluir'];
        
    $sql = $pdo->prepare("DELETE FROM tb_orcamento WHERE orcamento = '$numeroOrcamento'");
    $sql->bindValue(":orcamento", $numeroOrcamento);
    $sql->execute();   

    unset( $_SESSION['lista'] );
    unset( $_SESSION['cliente'] );
    unset( $_SESSION['numeroOrcamento'] );
    

    header("Location:/modelo.painel.1.php");

}