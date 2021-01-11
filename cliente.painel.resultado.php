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
        <link rel="stylesheet" href="assets/css/cadastroCliente.css">
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
                                <a href="index.php">Voltar</a>
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
                                                
                                                $cliente['FONEDDD1'] = "";
                                                $cliente['FONENRO1'] = "";
                                                $cliente['FONEDDD2'] = "";
                                                $cliente['FONENRO2'] = "";
                                                $cliente['FONEDDD3'] = "";
                                                $cliente['FONENRO3'] = "";

                                                echo "<table width=100%;>";
                                                echo "<tr>";
                                                echo "<td style='width:10%;'><strong>Endereco:</strong> ".$cliente['LOGRADOURO'].'<strong>  Nº</strong>'.$cliente['NROLOGRADOURO']."</td>";
                                                echo "<td style='width:10%;'><strong>Bairro:</strong> ".$cliente['BAIRRO']."</td>";
                                                echo "<td style='width:10%;'><strong>Cidade:</strong> ".$cliente['CIDADE']."</td>";
                                                echo "<td style='width:10%;'><strong>CEP:</strong> ".$cliente['CEP']."</td>"; 
                                                echo "<tr>";
                                                echo "</table>";  

                                                echo "<table width=100%;>";
                                                echo "<tr>";
                                                echo "<td style='width:10%;'><strong>Tel:</strong>(".$cliente['FONEDDD1'].") ".$cliente['FONENRO1']."</td>"; 
                                                echo "<td style='width:10%;'><strong>Tel:</strong>(".$cliente['FONEDDD2'].") ".$cliente['FONENRO2']."</td>"; 
                                                echo "<td style='width:10%;'><strong>Tel:</strong>(".$cliente['FONEDDD3'].") ".$cliente['FONENRO3']."</td>"; 
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