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

if($usuarios->temPermissao('ACO') == false) {
    header("Location:index.php");
    exit;
}

//=================================================================================================================

if(isset($_GET['cliente']) && !empty($_GET['cliente'])) { //se existir e ele nao estiver vazio.

    $cliente = addslashes($_GET['cliente']);                                        

    $consulta = "SELECT a.seqpessoa, a.nomerazao
    FROM 
    CONSINCO.GE_PESSOA a
    WHERE
    a.seqpessoa = '$cliente'
    ORDER BY a.nomerazao";                                         
    
    //prepara uma instrucao para execulsao
    $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

    //Executa os comandos SQL
    oci_execute($resultado);

    while (($cliente = oci_fetch_array($resultado, OCI_ASSOC)) != false) {
        $nomeCliente = $cliente['NOMERAZAO'];


    }

}


//=================================================================================================================

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Cliente</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/cadastroCliente2.css">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">

                        <?php require 'menuLateral.php'; ?>   
                        
                        </div>
                    </div>
                </div>

                <div class="conteudo-Central">
                    <div class="corpo">
                        <header class="desktop_header">
                            <div class="logo">
                                <img src="">
                            </div>
                            <div class="superiorMenu">                                
                                <a href="cliente.painel.pesquisa.php">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        <h1>CLIENTE: <?php echo $nomeCliente ?><h1>
                                    </div>
                                    
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <?php 
                                        if(isset($_GET['cliente']) && !empty($_GET['cliente'])) { //se existir e ele nao estiver vazio.

                                            $cliente = addslashes($_GET['cliente']);                                        

                                            $consulta = "SELECT * FROM CONSINCO.GE_PESSOA WHERE SEQPESSOA = '$cliente'";                                         
                                            
                                            //prepara uma instrucao para execulsao
                                            $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                            //Executa os comandos SQL
                                            oci_execute($resultado);

                                            while (($cliente = oci_fetch_array($resultado, OCI_ASSOC)) != false) {

                                                echo "<table width=100%;>";
                                                echo "<tr>";
                                                echo "<td><strong>Endereco:</strong> ".$cliente['LOGRADOURO'].'<strong>  Nº</strong>'.$cliente['NROLOGRADOURO']."</td>";
                                                echo "<td><strong>Bairro:</strong> ".$cliente['BAIRRO']."</td>";
                                                echo "<td><strong>Cidade:</strong> ".$cliente['CIDADE']."</td>";
                                                echo "<td><strong>CEP:</strong> ".$cliente['CEP']."</td>"; 
                                                echo "<tr>";
                                                echo "</table>";  

                                                echo "<table width=100%;>";
                                                echo "<tr>";

                                                if(empty($cliente['FONEDDD1']) && !empty($cliente['FONENRO1'])) {

                                                    echo "<td><strong>Tel:</strong> ".$cliente['FONENRO1']."</td>";  
                                                    
                                                } elseif(empty($cliente['FONENRO1']) && !empty($cliente['FONEDDD1'])) {

                                                    echo "<td><strong>Tel:</strong> ".$cliente['FONEDDD1']."</td>";     
                                                    
                                                } elseif(!empty($cliente['FONENRO1']) && !empty($cliente['FONEDDD1'])){

                                                    echo "<td><strong>Tel:</strong> ".$cliente['FONEDDD1'].'-'.$cliente['FONENRO1']."</td>";   

                                                } else {

                                                    echo "<td></td>";  

                                                }


                                                if(empty($cliente['FONEDDD2']) && !empty($cliente['FONENRO2'])) {

                                                    echo "<td><strong>Tel:</strong> ".$cliente['FONENRO2']."</td>";  
                                                    
                                                } elseif(empty($cliente['FONENRO2']) && !empty($cliente['FONEDDD2'])) {

                                                    echo "<td><strong>Tel:</strong> ".$cliente['FONEDDD2']."</td>";     
                                                    
                                                } elseif(!empty($cliente['FONENRO2']) && !empty($cliente['FONEDDD2'])){

                                                    echo "<td><strong>Tel:</strong> ".$cliente['FONEDDD2'].'-'.$cliente['FONENRO2']."</td>";   

                                                } else {

                                                    echo "<td></td>";  

                                                }


                                                if(empty($cliente['FONEDDD3']) && !empty($cliente['FONENRO3'])) {

                                                    echo "<td><strong>Tel:</strong> ".$cliente['FONENRO3']."</td>";  
                                                    
                                                } elseif(empty($cliente['FONENRO3']) && !empty($cliente['FONEDDD3'])) {

                                                    echo "<td><strong>Tel:</strong> ".$cliente['FONEDDD3']."</td>";     
                                                    
                                                } elseif(!empty($cliente['FONENRO3']) && !empty($cliente['FONEDDD3'])){

                                                    echo "<td><strong>Tel:</strong> ".$cliente['FONEDDD3'].'-'.$cliente['FONENRO3']."</td>";   

                                                } else {

                                                    echo "<td></td>";  

                                                }
                                                echo "<tr>";
                                                echo "</table>"; 

                                            }
                                        }

                                        if(isset($_GET['cliente']) && !empty($_GET['cliente'])) { //se existir e ele nao estiver vazio.

                                            $cliente = addslashes($_GET['cliente']);                                        

                                            $consulta = "SELECT a.seqpessoa, b.formapagto, c.statuscredito, c.vlrlimitecredito, c.conveniadocodigo, d.observacao
                                            FROM 
                                            CONSINCO.GE_PESSOA a,
                                            CONSINCO.mrl_formapagto b,
                                            CONSINCO.mrl_clientecredito c,
                                            CONSINCO.mrl_cliente d
                                            WHERE
                                            a.seqpessoa = '$cliente'
                                            AND a.seqpessoa = c.seqpessoa
                                            AND b.nroformapagto = c.nroformapagto
                                            AND a.seqpessoa = d.seqpessoa";                                        
                                            
                                            //prepara uma instrucao para execulsao
                                            $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                            //Executa os comandos SQL
                                            oci_execute($resultado);

                                            while (($credito = oci_fetch_array($resultado, OCI_ASSOC)) != false) { 
                                                ?>


                                                <table width=100%; <?php echo ($credito["STATUSCREDITO"] == 'L')?'style="background-color:#008000"':'';?>>
                                                

                                                <?php
                                                echo "<tr>";
                                               
                                                echo "<td><strong>Forma de Pagamento:</strong> ".$credito['FORMAPAGTO']."</td>";
                                                if($credito['STATUSCREDITO'] == 'L') {
                                                    echo "<td><strong>Status:</strong> LIBERADO</td>";
                                                } else {
                                                    echo "<td><strong>Status:</strong> BLOQUEADO</td>";
                                                }  
                                                echo "<td><strong>Limite:</strong>R$ ".$credito['VLRLIMITECREDITO']."</td>";
                                                if(empty($credito['CONVENIADOCODIGO'])) {

                                                    echo "<td></td>";

                                                } else {

                                                    echo "<td><strong>Convênio Nº:</strong> ".$credito['CONVENIADOCODIGO']."</td>";

                                                }
                                                

                                                echo "<tr>";
                                                echo "</table>";  

                                            }
                                        }
                                          

                                        if(isset($_GET['cliente']) && !empty($_GET['cliente'])) { //se existir e ele nao estiver vazio.

                                            $cliente = addslashes($_GET['cliente']);                                        

                                            $consulta = "SELECT a.seqpessoa, d.observacao
                                            FROM 
                                            CONSINCO.GE_PESSOA a,
                                            CONSINCO.mrl_cliente d
                                            WHERE
                                            a.seqpessoa = '$cliente'
                                            AND a.seqpessoa = d.seqpessoa";                                        
                                            
                                            //prepara uma instrucao para execulsao
                                            $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                            //Executa os comandos SQL
                                            oci_execute($resultado);

                                            while (($observacao = oci_fetch_array($resultado, OCI_ASSOC)) != false) { 

                                                echo "<table width=100%;>";
                                                echo "<tr>"; 
                                                if(empty($observacao['OBSERVACAO'])) {

                                                    echo "<td><strong>Observacão:</strong></td>";

                                                } else {

                                                    echo "<td><strong>Observacão:</strong> ".$observacao['OBSERVACAO']."</td>";

                                                }
                                                
                                                echo "<tr>";
                                                echo "</table>";  



                                            }
                                        }
                                        ?>                                         
                                    
                                    </div>
                                </div> 

                            </div> 
                        </section>
                    </div>
                </div>
            </div>
        </div>

    </body>


</html>