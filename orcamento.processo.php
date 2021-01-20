<?php

session_start();
require 'conexao.banco.php';
require 'conexao.banco.oracle.php';

//================================VARIAVEIS=========================================================================

$quantidade = "1.000";
$observacao = ".";
$medida = "Un";

//================================NUMERO DE ORÇAMENTO(ADICIONAR LISTA)================================================================

if(isset($_POST['adicionarOrcamento'])) {

    $sql = "SELECT MAX(orcamento) FROM tb_log_delivery";
    $sql = $pdo->query($sql);
    
    if($sql->rowCount() > 0) {
    
        $orcamento = $sql->fetch();
        $orcamento = $orcamento[0] + 1;   

        $_SESSION['orcamento'] = $orcamento; // cria a sessao orcamento

        if(isset($_SESSION['logado'])) {
            $usuario = $_SESSION['logado'];
            $data = date('Y-m-d');
            $tipo = 'O'; 
                
            $sql = $pdo->prepare("INSERT INTO tb_log_delivery SET orcamento = :orcamento, dataa = :dataa, usuario = :usuario, tipo = :tipo");
            $sql->bindValue(":dataa", $data);
            $sql->bindValue(":orcamento", $orcamento);
            $sql->bindValue(":usuario", $usuario);
            $sql->bindValue(":tipo", $tipo);
            $sql->execute();   
            
            header("Location:/orcamento.painel.2.php?orcamento=$orcamento"); 
        
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
            
            header("Location:/orcamento.painel.2.php?orcamento=$orcamento");
        
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
            
            header("Location:/orcamento.painel.2.php?cliente=$cliente");

        } else {

            //SE NAO EXISTIR, COLOQUE
            $_SESSION['cliente'] = array('id'=>$cliente['SEQPESSOA'], 'nome'=>$cliente['NOMERAZAO']); 

            header("Location:/orcamento.painel.2.php?cliente=$codCliente");        

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
        
        header("Location:/orcamento.painel.2.php");

    } else {

        //SE NAO EXISTIR, COLOQUE
        $_SESSION['formaPagamento'] = $formaPagamento;    

        header("Location:/orcamento.painel.2.php");        

    }
        
           
        
    
}

//================================BLOCO DE NOTAS================================================================

if(isset($_POST['blocoNotas'])) {

    $blocoNotas= addslashes($_POST['blocoNotas']);
    

    if(isset($_SESSION['blocoNotas'])) {   

        //SE EXISTIR, APAGUE E COLOQUE
        unset($_SESSION['blocoNotas']);
        $_SESSION['blocoNotas'] = array('checkbox' => 'checked', 'bloco'=>$blocoNotas);     

        header("Location:/orcamento.painel.2.php");

    } else {

        //SE NAO EXISTIR, COLOQUE
        $_SESSION['blocoNotas'] = array('checkbox' => 'checked', 'bloco'=>$blocoNotas);  

        header("Location:/orcamento.painel.2.php");        

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
            
                header("Location:/orcamento.painel.2.php");     

            } 
            
            if(isset($_GET['quantidade'])) {
            
                $codigoProduto = $_GET['codigoProduto'];
                $quantidade = number_format($_GET['quantidade'],3,".",",");
            
                $_SESSION['lista'][$codigoProduto]['quantidade'] = $quantidade;

                header("Location:/orcamento.painel.2.php");                
            
            }     

            if(isset($_GET['medida'])) {
            
                $codigoProduto = $_GET['codigoProduto'];
                $medida = addslashes($_GET['medida']);

                $_SESSION['lista'][$codigoProduto]['medida'] = $medida;

                header("Location:/orcamento.painel.2.php");                
            
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

            header("Location:/orcamento.painel.2.php");

        }  
        header("Location:/orcamento.painel.2.php");
    }
    header("Location:/orcamento.painel.2.php");
}

//================================SALVAR LISTA DE PRODUTOS================================================================

if(isset($_POST['salvarLista'])) {

    if(isset($_SESSION['cliente'], $_SESSION['formaPagamento'], $_SESSION['orcamento'], $_SESSION['lista'])) {             
        
        $usuario = $_SESSION['logado']; 
        $orcamento = $_SESSION['orcamento'];   
        $idCliente = $_SESSION['cliente']['id']; 
        $formaPagamento = $_SESSION['formaPagamento'];

        if(!empty($_SESSION['cliente'])) {             

            
            $sql = $pdo->prepare("UPDATE tb_log_delivery SET idCliente = :idCliente, pagamento = :pagamento, dataPedido = NOW() WHERE orcamento = :orcamento");
            $sql->bindValue(":idCliente", $idCliente);
            $sql->bindValue(":pagamento", $formaPagamento);
            $sql->bindValue(":orcamento", $orcamento);
            $sql->execute();     
        
        }    

        if(!empty($_SESSION['lista'])) {

            foreach($_SESSION['lista'] as $key=>$value) {
        
                $quantidade = $value['quantidade'];
                $gondola = $value['gondola'];
                $ean = $value['codigoEan'];
                $produto = $value['produto'];
                $preco = $value['preco'];
                $codigo = $value['codigo'];
                $medida = $value['medida'];
                $estoque = $value['estoque'];
                $pedido = 'N';
                $observacao = $value['observacao'];

                $sql = $pdo->prepare("INSERT INTO tb_orcamento SET dataa = NOW(), medida = :medida, orcamento = :orcamento, c_gondola = :c_gondola,
                ean = :ean, produto = :produto, c_produto = :c_produto, quantidade = :quantidade, valor_total = :valorTotal, estoque = :estoque, pedido = :pedido,
                observacao = :observacao, usuario = :usuario");
                
                $sql->bindValue(":orcamento", $orcamento);
                $sql->bindValue(":c_gondola", $gondola);
                $sql->bindValue(":c_produto", $codigo);
                $sql->bindValue(":ean", $ean);
                $sql->bindValue(":produto", $produto);
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

        header("Location:/orcamento.painel.1.php");

    } else {
 
        header("Location:/orcamento.painel.2.php");

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
    

    header("Location:/orcamento.painel.1.php");  
    exit;

}

//================================EXCLUIR PRODUTO================================================================

if(isset($_GET['excluir'])) {

    $produto = $_GET['excluir'];

    if(isset($_SESSION['lista'])){

        unset($_SESSION['lista'][$produto]);
        header("Location:/orcamento.painel.2.php");
        
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
 
    header("Location:/orcamento.editar.php?orcamento=$orcamento");  
    exit;

}