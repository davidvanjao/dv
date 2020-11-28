<?php

session_start();
require 'conexao.banco.php';

//================================VARIAVEIS=========================================================================

$quantidade = "1.000";
$observacao = "1";


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

//================================ADICIONAR PRODUTO================================================================

if(isset($_GET['produto'])) {

    $produto = $_GET['produto'];
    
    $sql = "SELECT n_gondola, c_produto, d_produto, preco, estoque FROM tb_produto WHERE c_produto = $produto";    
    $sql = $pdo->query($sql);                                    
    
    if($sql->rowCount() > 0) {
        foreach($sql as $key => $value) {

            if(isset($_SESSION['lista'][$produto])) {

                $quantidade = number_format($_GET['quantidade'],3,".",",");

                $_SESSION['lista'][$produto]['quantidade'] = $quantidade;
                $_SESSION['lista'][$produto]['observacao'] = $observacao;

                echo $quantidade;
                echo $observacao;

                //header("Location:/modelo.painel.2.php");

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


//================================PESQUISAR PRODUTO================================================================

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
        $status = 'PEDIDO REALIZADO';     
        
        $sql = $pdo->prepare("UPDATE tb_log_delivery SET idCliente = :idCliente, idEndereco = :idEndereco, statuss = :statuss, dataPedido = NOW() WHERE orcamento = '$orcamento'");
        $sql->bindValue(":idCliente", $idCliente);
        $sql->bindValue(":idEndereco", $idEndereco);    
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

            $sql = $pdo->prepare("INSERT INTO tb_orcamento SET dataa = :dataa, orcamento = :orcamento, c_gondola = :c_gondola,
            c_produto = :c_produto, quantidade = :quantidade, valor_total = :valorTotal, estoque = :estoque, usuario = :usuario");
            $sql->bindValue(":dataa", $data);
            $sql->bindValue(":orcamento", $orcamento);
            $sql->bindValue(":c_gondola", $gondola);
            $sql->bindValue(":c_produto", $codigo);
            $sql->bindValue(":quantidade",$quantidade);
            $sql->bindValue(":valorTotal", $preco);
            $sql->bindValue(":usuario", $usuario);
            $sql->bindValue(":estoque", $estoque);
            $sql->execute();        
            

    
        }

        unset( $_SESSION['lista'] );
        unset( $_SESSION['cliente'] );
        unset( $_SESSION['orcamento'] );     
    }

    

    header("Location:/modelo.painel.1.php");
    exit;

    

}