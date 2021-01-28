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

if(isset($_GET['pesquisa']) && empty($_GET['pesquisa']) == false){

    $pesquisa = addslashes($_GET['pesquisa']);                                                 

    $consulta = "SELECT A.NROPEDVENDA, B.NOMERAZAO, B.LOGRADOURO, B.NROLOGRADOURO, B.CIDADE, B.FONEDDD1, B.FONENRO1, A.DTAINCLUSAO
    FROM 
    CONSINCO.MAD_PEDVENDA  A,
    CONSINCO.GE_PESSOA B
    WHERE 
    A.SEQPESSOA = B.SEQPESSOA
    AND A.NROPEDVENDA = '$pesquisa'";
    
}

//=================================================================================================================

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Orçamento</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/delivery.css">
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

                                <a href="orcamento.painel.1.php">Orçamento</a> 
                                <a href="orcamento.cestaBasica.php">Cesta Básica</a> 
                                <a href="sair.php">Sair</a>                             
                                
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir orcamento1">
                                        <form class="busca-area" name="buscar-form" method="GET">
                                            <input class="input-busca-produto" minlength="3" type="text" name="pesquisa" placeholder="Digite sua busca">
                                            <input class="input-botao" type="submit" name="botao" value="Pesquisar">
                                        </form>
                                    </div>
                                    
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">ORCAMENTO</th>
                                                <th style="width:10%;">DATA</th>
                                                <th style="width:10%;">NOME</th>
                                                <th style="width:10%;">ENDEREÇO</th>
                                                <th style="width:5%;">AÇÕES</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php   
                                            
                                            if(isset($_GET['pesquisa']) && !empty($_GET['pesquisa'])) {

                                                //prepara uma instrucao para execulsao
                                                $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                                //Executa os comandos SQL
                                                oci_execute($resultado);

                                                while (($orcamento = oci_fetch_array($resultado, OCI_ASSOC)) != false) { 

                                                    echo "<tr>";
                                                    echo "<td style='width:10%;'>".@$orcamento['NROPEDVENDA']."</td>";
                                                    echo "<td style='width:10%;'>".@$orcamento['DTAINCLUSAO']."</td>";
                                                    echo "<td style='width:10%;'>".@$orcamento['NOMERAZAO']."</td>";     
                                                    echo "<td style='width:10%;'>".@$orcamento['LOGRADOURO']."</td>";                                               
                                                    echo '<td style="width:5%; background-color:#ff0000;"><a href="orcamento.impressao.cestaBasica.php?orcamento='.@$orcamento['NROPEDVENDA'].'" target="_blank">Imprimir</a></td>';           
                                                    echo "</tr>";  
                                                }

                                            }
                                            
                                            
                                                
                                            ?>                                        
                                        </table>
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