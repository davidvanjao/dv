<?php

session_start();
require 'conexao.banco.php';

//================================VARIAVEIS=========================================================================

$quantidade = "1.000";
$observacao = ".";
$medida = "Un";



//================================PROCESSO ACOUGUE================================================================

if(isset($_GET['liberarAcougue'])) {

    $orcamento = $_GET['liberarAcougue'];
    $pedido = 'S';

    $sql = $pdo->prepare("UPDATE tb_orcamento SET pedido = :pedido WHERE orcamento = $orcamento AND c_gondola = '96'");
    $sql->bindValue(":pedido", $pedido);
    $sql->execute();

    header("Location:/acougue.painel.1.php");
    exit;

}







//================================PROCESSO DE STATUS================================================================


if(isset($_GET['andamento']) && empty($_GET['andamento']) == false) {
    $id = $_GET['andamento'];
    $status = 'EM ANDAMENTO';
    $dataIniciar = "";

    $sql = $pdo->prepare("UPDATE tb_log_delivery SET statuss = :statuss, dataIniciar = NOW() WHERE id = $id");
    $sql->bindValue(":statuss", $status);
    //$sql->bindValue(":dataIniciar", $dataIniciar);
    $sql->execute();

    header("Location:/delivery.painel.3.php");
    exit;

} 

if(isset($_GET['liberado'])) {

    $id = $_POST['id'];
    $data = $_POST['data'];
    $cupom = $_POST['cupom']; 
    $valor = str_replace(",",".",$_POST['valor']);    
    $status = 'LIBERADO PARA ENTREGA';
    $dataLiberar = "";

    $sql = $pdo->prepare("UPDATE tb_log_delivery SET dataa = :dataa, cupom = :cupom, valor = :valor, statuss = :statuss, dataLiberar = NOW() WHERE id = $id");
    $sql->bindValue(":dataa", $data);
    $sql->bindValue(":cupom", $cupom);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":statuss", $status);
    $sql->execute();

    header("Location:/delivery.painel.3.php");
    exit;

}

if(isset($_GET['saiu'])) {
    $id = addslashes($_GET['saiu']);

    $sql = "SELECT a.id, a.dataa, b.nome, c.cidadeEstado, c.logradouro, b.numero, a.statuss
    from tb_log_delivery as a join tb_cliente as b join tb_endereco as c 
    on a.idCliente = b.id 
    and b.idEndereco = c.id
    where a.id = '$id'";

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {

        $log = $sql->fetch();
        
        $status = 'SAIU PARA ENTREGA';
        $data = date('Y-m-d');
        $dataEntregar = "";
    
        $sql = $pdo->prepare("UPDATE tb_log_delivery SET dataa = :dataa, statuss = :statuss, dataEntregar = NOW() WHERE id = $id");
        $sql->bindValue(":dataa", $data);
        $sql->bindValue(":statuss", $status);
        $sql->execute();
    
        header("Location:/delivery.painel.3.php");    
        exit;
        
    }



} 

    


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
            
            header("Location:/delivery.painel.2.php?orcamento=$orcamento");
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
            
            header("Location:/delivery.painel.2.php?orcamento=$orcamento");
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
                
                header("Location:/delivery.painel.2.php?cliente=$cliente");

            } else {

                //SE NAO EXISTIR, COLOQUE
                $_SESSION['cliente'] = array('id'=>$value['id'], 'idEndereco'=>$value['idEndereco'], 'nome'=>$value['nome']);  

                header("Location:/delivery.painel.2.php?cliente=$cliente");        

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
        
        header("Location:/delivery.painel.2.php");

    } else {

        //SE NAO EXISTIR, COLOQUE
        $_SESSION['formaPagamento'] = $formaPagamento;    

        header("Location:/delivery.painel.2.php");        

    }
        
           
        
    
}

//================================BLOCO DE NOTAS================================================================

if(isset($_POST['blocoNotas'])) {

    $blocoNotas= addslashes($_POST['blocoNotas']);
    

    if(isset($_SESSION['blocoNotas'])) {   

        //SE EXISTIR, APAGUE E COLOQUE
        unset($_SESSION['blocoNotas']);
        $_SESSION['blocoNotas'] = array('checkbox' => 'checked', 'bloco'=>$blocoNotas);     

        header("Location:/delivery.painel.2.php");

    } else {

        //SE NAO EXISTIR, COLOQUE
        $_SESSION['blocoNotas'] = array('checkbox' => 'checked', 'bloco'=>$blocoNotas);  

        header("Location:/delivery.painel.2.php");        

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
                
                    header("Location:/delivery.painel.2.php");     

                } 
                if(isset($_GET['quantidade'])) {
                
                    $produto = $_GET['produto'];
                    $quantidade = number_format($_GET['quantidade'],3,".",",");
                
                    $_SESSION['lista'][$produto]['quantidade'] = $quantidade;

                    header("Location:/delivery.painel.2.php");                
                
                }     
                if(isset($_GET['medida'])) {
                
                    $produto = $_GET['produto'];
                    $medida = addslashes($_GET['medida']);

                    $_SESSION['lista'][$produto]['medida'] = $medida;

                    header("Location:/delivery.painel.2.php");                
                
                }  
                
                


            } else {

                $_SESSION['lista'][$produto] = array('medida'=>$medida, 'quantidade'=>$quantidade, 'gondola'=>$value['n_gondola'], 'produto'=>$value['d_produto'],
                'preco'=>floatval($value['preco']), 'estoque'=>$value['estoque'], 'codigo'=>$value['c_produto'], 'observacao'=>$observacao);

                header("Location:/delivery.painel.2.php");

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
			echo '<tr ondblclick=location.href="delivery.processo.php?produto='.$produto['c_produto'].'" style="cursor:pointer">';
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

    if(isset($_SESSION['cliente'], $_SESSION['formaPagamento'], $_SESSION['orcamento'], $_SESSION['lista'])) {  

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

        if(!empty($_SESSION['cliente'])) {

            foreach($_SESSION['lista'] as $key=>$value) {
                $data = date('Y-m-d');
        
                $quantidade = $value['quantidade'];
                $gondola = $value['gondola'];
                $preco = $value['preco'];
                $codigo = $value['codigo'];
                $medida = $value['medida'];
                $estoque = $value['estoque'];
                $pedido = 'N';
                $observacao = $value['observacao'];

                $sql = $pdo->prepare("INSERT INTO tb_orcamento SET dataa = :dataa, medida = :medida, orcamento = :orcamento, c_gondola = :c_gondola,
                c_produto = :c_produto, quantidade = :quantidade, valor_total = :valorTotal, estoque = :estoque, pedido = :pedido, observacao = :observacao, usuario = :usuario");
                $sql->bindValue(":dataa", $data);
                $sql->bindValue(":orcamento", $orcamento);
                $sql->bindValue(":c_gondola", $gondola);
                $sql->bindValue(":c_produto", $codigo);
                $sql->bindValue(":quantidade",$quantidade);
                $sql->bindValue(":valorTotal", $preco);
                $sql->bindValue(":usuario", $usuario);
                $sql->bindValue(":estoque", $estoque);
                $sql->bindValue(":medida", $medida);
                $sql->bindValue(":pedido", $pedido);
                $sql->bindValue(":observacao", $observacao);
                $sql->execute();       
            }

            unset( $_SESSION['lista'] );
            unset( $_SESSION['cliente'] );
            unset( $_SESSION['orcamento'] );    
            unset( $_SESSION['formaPagamento'] ); 
            unset( $_SESSION['formaPagamento'] );
            unset( $_SESSION['blocoNotas']); 
        }

        header("Location:/delivery.painel.1.php");
        exit;

    } else {

       header("Location:/delivery.painel.2.php");
    }
    

}

//================================LIMPAR LISTA DE PRODUTOS================================================================

if(isset($_POST['excluirLista']) OR isset($_GET['excluirLista'])) {

    $orcamento = $_SESSION['orcamento'];

    $sql = $pdo->prepare("DELETE FROM tb_log_delivery WHERE orcamento = :orcamento");
    $sql->bindValue(":orcamento", $orcamento);
    $sql->execute();   

    unset( $_SESSION['orcamento'] );
    unset( $_SESSION['cliente'] );
    unset( $_SESSION['lista'] );
    unset( $_SESSION['formaPagamento'] );
    unset( $_SESSION['blocoNotas']);
    

    header("Location:/delivery.painel.1.php");  
    exit;

}

//================================EXCLUIR PRODUTO================================================================

if(isset($_GET['excluir'])) {

    $produto = $_GET['excluir'];

    if(isset($_SESSION['lista'])){

        unset($_SESSION['lista'][$produto]);
        header("Location:/delivery.painel.2.php");
        
    }
}

//================================EDITAR EXCLUIR PRODUTO================================================================

if(isset($_GET['Editarexcluir'])) {

    $produto = $_GET['Editarexcluir'];
    $orcamento = $_GET['orcamento'];

    $sql = $pdo->prepare("DELETE FROM tb_orcamento WHERE orcamento = :orcamento AND c_produto = :c_produto");
    $sql->bindValue(":orcamento", $orcamento);
    $sql->bindValue(":c_produto", $produto);
    $sql->execute();   
 
    header("Location:/delivery.editar.php?orcamento=$orcamento");  
    exit;
    //echo $orcamento;

}