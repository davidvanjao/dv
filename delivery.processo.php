<?php

session_start();
require 'conexao.banco.php';
require 'conexao.banco.oracle.php';

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

    


//================================NUMERO DE ORÇAMENTO(ADICIONAR LISTA)================================================================

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
        
        }
    
    } else {
    
        $orcamento = 1;

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
        
        }
        
    }

}

//================================ADICIONAR CLIENTE (CODCLIENTE)================================================================

if(isset($_GET['codCliente'])) {

    $codCliente = addslashes($_GET['codCliente']);                                  

    $consulta = "SELECT * FROM CONSINCO.GE_PESSOA WHERE SEQPESSOA = '$codCliente'";                                         
    
    //prepara uma instrucao para execulsao
    $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

    //Executa os comandos SQL
    oci_execute($resultado);

    while (($cliente = oci_fetch_array($resultado, OCI_ASSOC)) != false) {

        if(isset($_SESSION['cliente'])) {   

            //SE EXISTIR, APAGUE E COLOQUE
            unset( $_SESSION['cliente'] );
            $_SESSION['cliente'] = array('id'=>$cliente['SEQPESSOA'], 'nome'=>$cliente['NOMERAZAO']);         
            
            header("Location:/delivery.painel.2.php?cliente=$cliente");

        } else {

            //SE NAO EXISTIR, COLOQUE
            $_SESSION['cliente'] = array('id'=>$cliente['SEQPESSOA'], 'nome'=>$cliente['NOMERAZAO']); 

            header("Location:/delivery.painel.2.php?cliente=$codCliente");        

        }

    }
}

//================================ADICIONAR FORMA DE PAGAMENTO (FORMAPAGAMENTO)================================================================

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


if(isset($_GET['codigoProduto'])) {    

    $codigoProduto = $_GET['codigoProduto'];

    $consulta = "SELECT d.codacesso, a.seqproduto, b.desccompleta, a.estqloja, a.nrogondola,
    consinco.fprecoembnormal(a.seqproduto, 1, e.nrosegmentoprinc, a.nroempresa) preco,
    consinco.fprecoembpromoc(a.seqproduto, 1, e.nrosegmentoprinc, a.nroempresa) precoprom,
    a.estqloja
    FROM
    consinco.mrl_produtoempresa a, 
    consinco.map_produto b, 
    consinco.map_prodcodigo d,
    consinco.max_empresa e
    WHERE
    a.nroempresa = '1'
    AND e.nroempresa = '1'
    AND a.seqproduto = b.seqproduto
    AND a.seqproduto = d.seqproduto
    AND d.tipcodigo IN ('E', 'B')
    AND a.statuscompra = 'A'
    AND a.seqproduto = '$codigoProduto'
    ORDER BY b.desccompleta";

    //prepara uma instrucao para execulsao
    $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

    //Executa os comandos SQL
    oci_execute($resultado);

    while (($value = oci_fetch_array($resultado, OCI_ASSOC)) != false) {     
        
        if(isset($_SESSION['lista'][$codigoProduto])) {

            if(isset($_GET['observacao'])) {

                $codigoProduto = $_GET['codigoProduto'];
                $observacao = $_GET['observacao'];                       
            
                $_SESSION['lista'][$codigoProduto]['observacao'] = $observacao;                
            
                header("Location:/delivery.painel.2.php");     

            } 
            
            if(isset($_GET['quantidade'])) {
            
                $codigoProduto = $_GET['codigoProduto'];
                $quantidade = number_format($_GET['quantidade'],3,".",",");
            
                $_SESSION['lista'][$codigoProduto]['quantidade'] = $quantidade;

                header("Location:/delivery.painel.2.php");                
            
            }     

            if(isset($_GET['medida'])) {
            
                $codigoProduto = $_GET['codigoProduto'];
                $medida = addslashes($_GET['medida']);

                $_SESSION['lista'][$codigoProduto]['medida'] = $medida;

                header("Location:/delivery.painel.2.php");                
            
            }  
            
        } else {

            $consulta2 = "SELECT *
            FROM (SELECT a.seqproduto, a.seqfamilia, b.qtdembalagem, b.embalagem FROM consinco.map_produto a, consinco.map_famembalagem b WHERE a.seqfamilia = b.seqfamilia AND a.seqproduto = '$codigoProduto' ORDER BY b.qtdembalagem) 
            WHERE rownum <= 1";

            //prepara uma instrucao para execulsao
            $resultado2 = oci_parse($ora_conexao, $consulta2) or die ("erro");

            //Executa os comandos SQL
            oci_execute($resultado2);

            while (($embalagem = oci_fetch_array($resultado2, OCI_ASSOC)) != false) { 

                $medida = $embalagem['EMBALAGEM'];

                //var_dump($medida);

            }  
            
            if($value['PRECOPROM'] > '0') {                                                    
                $valor = $value['PRECOPROM'];
            } else {                                                    
                $valor = $value['PRECO'];
            }

            $_SESSION['lista'][$codigoProduto] = array(
                'medida'=>$medida, 
                'quantidade'=>$quantidade, 
                'gondola'=>$value['NROGONDOLA'], 
                'produto'=>$value['DESCCOMPLETA'],
                'preco'=>floatval($valor), 
                'estoque'=>$value['ESTQLOJA'], 
                'codigo'=>$value['SEQPRODUTO'], 
                'codigoEan'=>$value['CODACESSO'], 
                'observacao'=>$observacao);

            header("Location:/delivery.painel.2.php");

        }  
        header("Location:/delivery.painel.2.php");
    }
    header("Location:/delivery.painel.2.php");
}


//================================PESQUISAR PRODUTO================================================================


/*if(!empty($_POST['pesquisa'])) { //se existir/ e ele nao estiver vazio.

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
}*/


//================================SALVAR LISTA DE PRODUTOS================================================================

if(isset($_POST['salvarLista'])) {

    if(isset($_SESSION['cliente'], $_SESSION['formaPagamento'], $_SESSION['orcamento'], $_SESSION['lista'])) {             
        
        $usuario = $_SESSION['logado']; 
        $orcamento = $_SESSION['orcamento'];   
        $idCliente = $_SESSION['cliente']['id']; 
        $formaPagamento = $_SESSION['formaPagamento'];

        if(!empty($_SESSION['cliente'])) {              

            $status = 'PEDIDO REALIZADO';     
            
            $sql = $pdo->prepare("UPDATE tb_log_delivery SET idCliente = :idCliente, pagamento = :pagamento, statuss = :statuss, dataPedido = NOW() WHERE orcamento = :orcamento");
            $sql->bindValue(":idCliente", $idCliente);
            $sql->bindValue(":pagamento", $formaPagamento);
            $sql->bindValue(":statuss", $status);
            $sql->bindValue(":orcamento", $orcamento);
            $sql->execute();          
        
        }    

        if(!empty($_SESSION['lista'])) {

            foreach($_SESSION['lista'] as $key=>$value) {
        
                $quantidade = $value['quantidade'];
                $gondola = $value['gondola'];
                $preco = $value['preco'];
                $codigo = $value['codigo'];
                $medida = $value['medida'];
                $estoque = $value['estoque'];
                $pedido = 'N';
                $observacao = $value['observacao'];

                $sql = $pdo->prepare("INSERT INTO tb_orcamento SET dataa = NOW(), medida = :medida, orcamento = :orcamento, c_gondola = :c_gondola,
                c_produto = :c_produto, quantidade = :quantidade, valor_total = :valorTotal, estoque = :estoque, pedido = :pedido, observacao = :observacao, usuario = :usuario");
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
            unset( $_SESSION['blocoNotas']); 
        }

        header("Location:/delivery.painel.1.php");

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