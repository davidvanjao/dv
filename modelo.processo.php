<?php

require 'conexao.banco.php';

//================================================================================================

$idCliente = "";
$nomeCliente ="";
$numeroOrcamento="";
$resultado=0;
$valorGeral=0;

if(isset($_POST['orcamentoPainel'])) {
    $numeroOrcamento = $_POST['orcamentoPainel'];
    $data = date('Y-m-d');
        
    $sql = $pdo->prepare("INSERT INTO tb_log_delivery SET orcamento = :orcamento, dataa = :dataa, dataPedido = NOW()");
    $sql->bindValue(":dataa", $data);
    $sql->bindValue(":orcamento", $numeroOrcamento);
    $sql->execute();   
    
    header("Location:/modelo.painel.2.php?orcamento=$numeroOrcamento");
    exit;

}




/*if(isset($_GET['quantidade']) && isset($_GET['codigo'])) {

    $codigoProduto = $_GET['codigo'];
    $quantidadeProduto = $_GET['quantidade'];

    echo $codigoProduto;
    echo $quantidadeProduto;
                                
    //header("Location:/modelo.painel.2.php");
    
}*/


//echo $orcamento;
//echo $cliente;
//echo $numeroOrcamento;
//var_dump($_SESSION);
//session_destroy();

/*if(isset($_GET['adicionar'])) {

    $idProduto = (int)$_GET['adicionar'];
    
    $sql = "SELECT * FROM tb_produto WHERE id = $idProduto";    
    $sql = $pdo->query($sql);                                    
    
    if($sql->rowCount() > 0) {
        foreach($sql as $key => $value) {

            if(isset($value['id']) == $idProduto) {
                if(isset($_SESSION['orcamento'][$idProduto])){

                    if(isset($_POST['quantProd'])) {

    
                        $prodQuantidade = $_POST['quantProd'];
                        $_SESSION['orcamento'][$idProduto]['quantidade'] = $prodQuantidade;                                        
                    
                        
                    }

                        //$_SESSION['orcamento'][$idProduto]['quantidade']++;

                        //echo '<script>alert("Esse produto já existe na lista!");</script>';

                }else{

                    $_SESSION['orcamento'][$idProduto] = array('quantidade'=>1, 'produto'=>$value['d_produto'], 'preco'=>$value['preco'], 'estoque'=>$value['estoque'], 'codigo'=>$value['c_produto'], 'id'=>$value['id']);
                }
                
            }else{

                die('voce nao pode adicionar um item que nao existe.');
            }
        
                    
        }   
        
        
    } 
    
}

if(isset($_GET['id'])) {

    $idCliente = addslashes($_GET['id']);
    
    $sql = "SELECT a.id, a.nome, a.telefone, b.cidadeEstado, b.bairro, b.logradouro, a.numero 
    from tb_cliente a, tb_endereco b 
    where a.id = '$idCliente'
    and a.idEndereco = b.id";

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {

        foreach($sql as $key => $valueCliente) {


            if(isset($valueCliente['id']) == $idCliente) {
                

                $_SESSION['cliente'][$idCliente] = array('idCliente'=>$valueCliente['id'], 'nomeCliente'=>$valueCliente['nome']);

                
            } else{

                die('Operacao de adicionar cliente deu errado!');
            }        
                    
        }          
        
    }       
    
}


if(!empty($_SESSION['cliente'])) {

    foreach($_SESSION['cliente'] as $key=>$valueCliente) {

        if(!empty($_SESSION['cliente'])) { 
            $idCliente = $valueCliente['idCliente'];
            $nomeCliente = $valueCliente['nomeCliente'];
        } else {
            
        }

    }

    
}



if(isset($_SESSION['logado'])) {

    $sql = "SELECT MAX(id) FROM tb_log_delivery";
    $sql = $pdo->query($sql);
    
    if($sql->rowCount() > 0) {
    
        $orcamento = $sql->fetch();
        $orcamento = $orcamento[0] + 1;   
    
    } else {
    
        echo "Não deu certo o orcamento";
    }


}*/


//echo $orcamento;
//echo $cliente;
//var_dump($_SESSION);
//session_destroy();