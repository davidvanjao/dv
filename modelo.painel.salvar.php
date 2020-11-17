<?php

session_start();

require 'conexao.banco.php';

if(isset($_POST['salvar'])) {

    if(!empty($_SESSION['logado'])) {       
    
            $usuario = $_SESSION['logado'];   
        
        
    }

    if(!empty($_SESSION['numeroOrcamento'])) {

        foreach($_SESSION['numeroOrcamento'] as $key=>$valueOrcamento) {
    
            $numeroOrc = $valueOrcamento['orcamento'];
    
        }
        
    }
    if(!empty($_SESSION['lista'])) {

        foreach($_SESSION['lista'] as $key=>$value) {
            $data = date('Y-m-d');
    
            $quantidade = $value['quantidade'];
            $gondola = $value['gondola'];
            $preco = $value['preco'];
            $codigo = $value['codigo'];

            $sql = $pdo->prepare("INSERT INTO tb_orcamento SET dataa = :dataa, orcamento = :orcamento, c_gondola = :c_gondola, c_produto = :c_produto, quantidade = :quantidade, valor_total = :valorTotal, usuario = :usuario");
            $sql->bindValue(":dataa", $data);
            $sql->bindValue(":orcamento", $numeroOrc);
            $sql->bindValue(":c_gondola", $gondola);
            $sql->bindValue(":c_produto", $codigo);
            $sql->bindValue(":quantidade",$quantidade);
            $sql->bindValue(":valorTotal", $preco);
            $sql->bindValue(":usuario", $usuario);

            $sql->execute();        

    
        }

            unset( $_SESSION['lista'] );
            unset( $_SESSION['cliente'] );
            unset( $_SESSION['numeroOrcamento'] );

            header("Location:/modelo.painel.1.php");

            exit;
        
    }
    

    //header("Location:/modelo.painel.1.php");

}