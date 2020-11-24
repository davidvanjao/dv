<?php

session_start();
require 'conexao.banco.php';

//================================VARIAVEIS=========================================================================




//================================NUMERO DE ORÇAMENTO================================================================

if(isset($_POST['adicionaLista'])) {

    $sql = "SELECT MAX(orcamento) FROM tb_log_delivery";
    $sql = $pdo->query($sql);
    
    if($sql->rowCount() > 0) {
    
        $orcamento = $sql->fetch();
        $orcamento = $orcamento[0] + 1;   

        $_SESSION['orcamento'] = $orcamento; // cria a sessao orcamento

        if(isset($_SESSION['logado'])) {
            $usuario = $_SESSION['logado'];
            $data = date('Y-m-d');
                
            $sql = $pdo->prepare("INSERT INTO tb_log_delivery SET orcamento = :orcamento, dataa = :dataa, usuario = :usuario");
            $sql->bindValue(":dataa", $data);
            $sql->bindValue(":orcamento", $orcamento);
            $sql->bindValue(":usuario", $usuario);
            $sql->execute();   
            
            header("Location:/modelo.painel.2.php?orcamento=$orcamento");
            //exit;  
        
        }
    
    } else {
    
        $orcamento = 1;

        if(isset($_SESSION['logado'])) {
            $usuario = $_SESSION['logado'];
            $data = date('Y-m-d');
                
            $sql = $pdo->prepare("INSERT INTO tb_log_delivery SET orcamento = :orcamento, dataa = :dataa, usuario = :usuario");
            $sql->bindValue(":dataa", $data);
            $sql->bindValue(":orcamento", $orcamento);
            $sql->bindValue(":usuario", $usuario);
            $sql->execute();   
            
            header("Location:/modelo.painel.2.php?orcamento=$orcamento");
            //exit;  
        
        }
        
    }

}

//================================ADICIONAR CLIENTE================================================================

if(isset($_GET['cliente'])) {

    $cliente = addslashes($_GET['cliente']);
    
    $sql = "SELECT id, idEndereco, nome FROM tb_cliente WHERE id = '$cliente'";

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {   

        foreach($sql as $key => $value) {  

            if(isset($_SESSION['cliente'])) {   

                //SE EXISTIR, APAGUE E COLOQUE
                unset( $_SESSION['cliente'] );
                $_SESSION['cliente'] = array('id'=>$value['id'], 'idEndereco'=>$value['idEndereco'], 'nome'=>$value['nome']);         
                
                header("Location:/modelo.painel.2.php?cliente=$cliente");

            } else {

                //SE NAO EXISTIR, COLOQUE
                $_SESSION['cliente'] = array('id'=>$value['id'], 'idEndereco'=>$value['idEndereco'], 'nome'=>$value['nome']);  

                header("Location:/modelo.painel.2.php?cliente=$cliente");        

            }
        }
           
    }      
    
}