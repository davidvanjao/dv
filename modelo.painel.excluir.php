<?php

session_start();

if(isset($_GET['excluir'])) {

    $idProduto = (int)$_GET['excluir'];
     
    //echo $idProduto;
    //var_dump($_SESSION);

    
    if(isset($_SESSION['orcamento'])){

        unset($_SESSION['orcamento'][$idProduto]);

        header("Location:/modelo.painel.2.php");
        
    }else{
        echo "Nao deu certo!";
    }


}
