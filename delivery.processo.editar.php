<?php

session_start();
require 'conexao.banco.php';
require 'conexao.banco.oracle.php';
require 'classes/usuarios.class.php';

if (isset($_SESSION['logado']) && empty($_SESSION['logado']) == false) {
} else {
    header("Location: login.php");
}

$usuarios = new Usuarios($pdo);
$usuarios->setUsuario($_SESSION['logado']);

if($usuarios->temPermissao('ORC') == false) {
    header("Location:index.php");
    exit;
}


//================================VARIAVEIS=========================================================================

$quantidade = "1.000";
$observacao = ".";
$medida = "Un";

//================================ADICIONAR PRODUTO================================================================

if(isset($_GET['codigoProduto']) && !empty($_GET['orcamento'])) {    

    $produto = $_GET['codigoProduto'];
    $orcamento = $_GET['orcamento'];

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
    AND a.seqproduto = '$produto'
    ORDER BY b.desccompleta";

    //prepara uma instrucao para execulsao
    $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

    //Executa os comandos SQL
    oci_execute($resultado);

    while (($value = oci_fetch_array($resultado, OCI_ASSOC)) != false) {     
        
        if(isset($_SESSION['lista'][$produto])) {
            
            if(isset($_GET['quantidade'])) {
            
                $produto = $_GET['codigoProduto'];
                $quantidade = number_format($_GET['quantidade'],3,".",",");
            
                $_SESSION['lista'][$produto]['quantidade'] = $quantidade;

                header("Location:/delivery.editar.php?orcamento=$orcamento");
                exit;              
            
            }     

            if(isset($_GET['medida'])) {
            
                $produto = $_GET['codigoProduto'];
                $medida = addslashes($_GET['medida']);

                $_SESSION['lista'][$produto]['medida'] = $medida;

                header("Location:/delivery.editar.php?orcamento=$orcamento");  
                exit;
                     
            
            }  

            if(isset($_GET['observacao'])) {

                $produto = $_GET['codigoProduto'];
                $observacao = $_GET['observacao'];                       
            
                $_SESSION['lista'][$produto]['observacao'] = $observacao;                
            
                header("Location:/delivery.editar.php?orcamento=$orcamento");   
                exit;   

            } 

            header("Location:/delivery.editar.php?orcamento=$orcamento"); 
            
        } else {

            $consulta2 = "SELECT *
            FROM (SELECT a.seqproduto, a.seqfamilia, b.qtdembalagem, b.embalagem FROM consinco.map_produto a, consinco.map_famembalagem b WHERE a.seqfamilia = b.seqfamilia AND a.seqproduto = '$produto' ORDER BY b.qtdembalagem) 
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

            $_SESSION['lista'][$produto] = array(
                'medida'=>$medida, 
                'quantidade'=>$quantidade, 
                'gondola'=>$value['NROGONDOLA'], 
                'produto'=>$value['DESCCOMPLETA'],
                'preco'=>floatval($valor), 
                'estoque'=>$value['ESTQLOJA'], 
                'codigo'=>$value['SEQPRODUTO'], 
                'codigoEan'=>$value['CODACESSO'], 
                'observacao'=>$observacao);

            header("Location:/delivery.editar.php?orcamento=$orcamento");

        }  
        
    }

}

//=====================================ATUALIZAR LISTA=========================================================

if(isset($_GET['atualizar'])) {

    $orcamento = $_GET['orcamento'];
    $usuario = $_SESSION['logado'];

    if(isset($_SESSION['lista'])) { 

        foreach($_SESSION['lista'] as $key=>$value) {

            $medida = $value['medida'];
            $quantidade = $value['quantidade'];
            $gondola = $value['gondola'];
            $produto = $value['produto'];
            $preco = $value['preco'];
            $estoque = $value['estoque'];
            $codigo = $value['codigo'];
            $ean = $value['codigoEan'];
            $observacao = $value['observacao'];
            $pedido = 'N';


            $sql = $pdo->prepare("INSERT INTO tb_orcamento SET dataa = NOW(), medida = :medida, quantidade = :quantidade, c_gondola = :c_gondola, produto = :produto,
            valor_total = :valor_total, estoque = :estoque, c_produto = :c_produto, ean = :ean, usuario = :usuario, orcamento = :orcamento, observacao = :observacao, pedido = :pedido");

            $sql->bindValue(":medida", $medida);
            $sql->bindValue(":quantidade",$quantidade);
            $sql->bindValue(":c_gondola", $gondola);
            $sql->bindValue(":produto", $produto);
            $sql->bindValue(":valor_total", $preco);
            $sql->bindValue(":estoque", $estoque);
            $sql->bindValue(":c_produto", $codigo);
            $sql->bindValue(":ean", $ean);
            $sql->bindValue(":usuario", $usuario);
            $sql->bindValue(":orcamento", $orcamento);
            $sql->bindValue(":observacao", $observacao);
            $sql->bindValue(":pedido", $pedido);
            $sql->execute(); 

 
        }

            unset( $_SESSION['lista'] );
            unset( $_SESSION['cliente'] );
            unset( $_SESSION['orcamento'] );    
            unset( $_SESSION['formaPagamento'] ); 
            unset( $_SESSION['blocoNotas']); 
            unset( $_SESSION['dataEntrega']);

            header("Location:/delivery.painel.1.php");

    }

    header("Location:/delivery.painel.1.php");
    

}

//====================================LIMPAR LISTA AO SAIR=================================================

if(isset($_GET['sairEditar'])) {

    unset( $_SESSION['orcamento'] );
    unset( $_SESSION['cliente'] );
    unset( $_SESSION['lista'] );
    unset( $_SESSION['formaPagamento'] );
    unset( $_SESSION['blocoNotas']);    

    header("Location:/orcamento.painel.1.php");  
    exit;

}

//================================EXCLUIR ITEM================================================================

if(isset($_GET['excluirItem'])) {

    $produto = $_GET['excluirItem'];
    $orcamento = $_GET['orcamento'];

    $sql = $pdo->prepare("DELETE FROM tb_orcamento WHERE orcamento = :orcamento AND c_produto = :c_produto");
    $sql->bindValue(":orcamento", $orcamento);
    $sql->bindValue(":c_produto", $produto);
    $sql->execute();   
 
    header("Location:/delivery.editar.php?orcamento=$orcamento"); 
    exit;

}

//================================EXCLUIR ITEM DA SESSAO================================================================

if(isset($_GET['excluirItemSessao'])) {

    $produto = $_GET['excluirItemSessao'];
    $orcamento = $_GET['orcamento'];

    if(isset($_SESSION['lista'])){

        unset($_SESSION['lista'][$produto]);
        header("Location:/delivery.editar.php?orcamento=$orcamento"); 
        exit;        
    }
}
