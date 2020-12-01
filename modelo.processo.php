<?php

session_start();
require 'conexao.banco.php';

//================================VARIAVEIS=========================================================================

$quantidade = "1.000";
$observacao = ".";


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

//================================ADICIONAR FORMA DE PAGAMENTO================================================================

if(isset($_POST['formaPagamento'])) {

    $formaPagamento= addslashes($_POST['formaPagamento']);
    

    if(isset($_SESSION['formaPagamento'])) {   

        //SE EXISTIR, APAGUE E COLOQUE
        unset( $_SESSION['formaPagamento'] );
        $_SESSION['formaPagamento'] = $formaPagamento;         
        
        header("Location:/modelo.painel.2.php");

    } else {

        //SE NAO EXISTIR, COLOQUE
        $_SESSION['formaPagamento'] = $formaPagamento;    

        header("Location:/modelo.painel.2.php");        

    }
        
           
        
    
}

//================================BLOCO DE NOTAS================================================================

if(isset($_POST['blocoNotas'])) {

    $blocoNotas= addslashes($_POST['blocoNotas']);
    

    if(isset($_SESSION['blocoNotas'])) {   

        //SE EXISTIR, APAGUE E COLOQUE
        unset($_SESSION['blocoNotas']);
        $_SESSION['blocoNotas'] = array('checkbox' => 'checked', 'bloco'=>$blocoNotas);     

        header("Location:/modelo.painel.2.php");

    } else {

        //SE NAO EXISTIR, COLOQUE
        $_SESSION['blocoNotas'] = array('checkbox' => 'checked', 'bloco'=>$blocoNotas);  

        header("Location:/modelo.painel.2.php");        

    }
        
           
        
    
}

//================================ADICIONAR PRODUTO================================================================

if(isset($_GET['produto'])) {

    $produto = $_GET['produto'];
    
    $sql = "SELECT n_gondola, c_produto, d_produto, preco, estoque FROM tb_produto WHERE c_produto = $produto";    
    $sql = $pdo->query($sql);                                    
    
    if($sql->rowCount() > 0) {
        foreach($sql as $key => $value) {

            if(isset($_SESSION['lista'][$produto])) {

                if(isset($_GET['observacao'])) {

                    $produto = $_GET['produto'];
                    $observacao = $_GET['observacao'];                       
                
                    $_SESSION['lista'][$produto]['observacao'] = $observacao;                
                
                    header("Location:/modelo.painel.2.php");     

                } else {
                
                    $produto = $_GET['produto'];
                    $quantidade = number_format($_GET['quantidade'],3,".",",");
                
                    $_SESSION['lista'][$produto]['quantidade'] = $quantidade;

                    header("Location:/modelo.painel.2.php");                
                
                }                

            } else {

                $_SESSION['lista'][$produto] = array('quantidade'=>$quantidade, 'gondola'=>$value['n_gondola'], 'produto'=>$value['d_produto'],
                'preco'=>floatval($value['preco']), 'estoque'=>$value['estoque'], 'codigo'=>$value['c_produto'], 'observacao'=>$observacao);

                header("Location:/modelo.painel.2.php");

            }        
                    
        }   
        
        
    } else {

         echo "Pesquisa no banco não deu certo!";
    }

    
}


//================================PESQUISAR PRODUTO================================================================

if(!empty($_POST['pesquisa'])) { //se existir/ e ele nao estiver vazio.

	$pesquisa = $_POST['pesquisa'];
	$sql = "SELECT * FROM tb_produto WHERE preco !='0' AND d_produto LIKE '".$pesquisa."%'";
	
	$sql = $pdo->query($sql);                                    

	if($sql->rowCount() > 0) {
		foreach($sql->fetchAll() as $produto) {
            echo "<table>";
			echo '<tr ondblclick=location.href="modelo.processo.php?produto='.$produto['c_produto'].'" style="cursor:pointer">';
			echo "<td style='width:10%;'>".$produto['c_produto']."</td>";
			echo "<td style='width:50%;'>".$produto['d_produto']."</td>";
			echo "<td style='width:20%;'>R$ ".$produto['preco']."</td>";
			echo "<td style='width:10%;'>".$produto['estoque']."</td>";
            echo '</tr>';  
            echo "</table>";
		}
	} 
}


//================================SALVAR LISTA DE PRODUTOS================================================================

if(isset($_POST['salvarLista'])) {

    if(!empty($_SESSION['logado'])) {       
    
        $usuario = $_SESSION['logado'];           
        
    }

    if(!empty($_SESSION['orcamento'])) {

        $orcamento = $_SESSION['orcamento'];
        
    }

    if(!empty($_SESSION['cliente'])) {               
    
        $idCliente = $_SESSION['cliente']['id']; 
        $idEndereco = $_SESSION['cliente']['idEndereco'];
        $formaPagamento = $_SESSION['formaPagamento'];
        $status = 'PEDIDO REALIZADO';     
        
        $sql = $pdo->prepare("UPDATE tb_log_delivery SET idCliente = :idCliente, idEndereco = :idEndereco, pagamento = :pagamento, statuss = :statuss, dataPedido = NOW() WHERE orcamento = '$orcamento'");
        $sql->bindValue(":idCliente", $idCliente);
        $sql->bindValue(":idEndereco", $idEndereco);    
        $sql->bindValue(":pagamento", $formaPagamento);
        $sql->bindValue(":statuss", $status);
        $sql->execute();          
    
    }    

    if(!empty($_SESSION['lista'])) {

        foreach($_SESSION['lista'] as $key=>$value) {
            $data = date('Y-m-d');
    
            $quantidade = $value['quantidade'];
            $gondola = $value['gondola'];
            $preco = $value['preco'];
            $codigo = $value['codigo'];
            $estoque = $value['estoque'];
            $observacao = $value['observacao'];

            $sql = $pdo->prepare("INSERT INTO tb_orcamento SET dataa = :dataa, orcamento = :orcamento, c_gondola = :c_gondola,
            c_produto = :c_produto, quantidade = :quantidade, valor_total = :valorTotal, estoque = :estoque, observacao = :observacao, usuario = :usuario");
            $sql->bindValue(":dataa", $data);
            $sql->bindValue(":orcamento", $orcamento);
            $sql->bindValue(":c_gondola", $gondola);
            $sql->bindValue(":c_produto", $codigo);
            $sql->bindValue(":quantidade",$quantidade);
            $sql->bindValue(":valorTotal", $preco);
            $sql->bindValue(":usuario", $usuario);
            $sql->bindValue(":estoque", $estoque);
            $sql->bindValue(":observacao", $observacao);
            $sql->execute();        
            

    
        }

        unset( $_SESSION['lista'] );
        unset( $_SESSION['cliente'] );
        unset( $_SESSION['orcamento'] );    
        unset( $_SESSION['formaPagamento'] );  
    }

    

    header("Location:/modelo.painel.1.php");
    exit;

    

}

//================================LIMPAR LISTA DE PRODUTOS================================================================

if(isset($_POST['excluirLista'])) {

    $orcamento = $_SESSION['orcamento'];

    $sql = $pdo->prepare("DELETE FROM tb_log_delivery WHERE orcamento = :orcamento");
    $sql->bindValue(":orcamento", $orcamento);
    $sql->execute();   

    unset( $_SESSION['orcamento'] );
    unset( $_SESSION['cliente'] );
    unset( $_SESSION['lista'] );
    unset( $_SESSION['formaPagamento'] );
    unset( $_SESSION['blocoNotas']);
    

    header("Location:/modelo.painel.1.php");  

}

//================================EXCLUIR PRODUTO================================================================

if(isset($_GET['excluir'])) {

    $produto = $_GET['excluir'];

    if(isset($_SESSION['lista'])){

        unset($_SESSION['lista'][$produto]);
        header("Location:/modelo.painel.2.php");
        
    }
}