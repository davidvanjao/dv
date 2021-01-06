<?php

session_start();
require 'conexao.banco.php';
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



//=================================================================================================================

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Açougue</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/acougue.css">
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
                                        <!--<form class="busca-area" name="buscar-form" method="POST" action="delivery.processo.php">
                                            <input class="input-botao" type="submit" name="adicionaLista" value="Adicionar Lista">
                                        </form>-->

                                        <h1>PAINEL DE PEDIDOS - DELIVERY<h1>
                                    </div>
                                    
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <?php 
                                        if(isset($_SESSION['logado'])) {
                                            
                                            $sql = "SELECT a.orcamento, b.nome, b.telefone
                                            FROM tb_log_delivery a, tb_cliente b, tb_orcamento c
                                            WHERE c.c_gondola = '96'
                                            AND c.pedido = 'N'
                                            AND a.orcamento = c.orcamento
                                            AND a.idCliente = b.id
                                            GROUP BY a.orcamento";

                                            $sql = $pdo->query($sql);

                                            if($sql->rowCount() > 0) {        

                                                foreach($sql->fetchAll() as $delivery) { 
                                                    $orcamento = $delivery['orcamento'];
                                                    $nome = $delivery['nome'];
                                                    $telefone = $delivery['telefone'];

                                                    
                                                    echo "<div class='tecket-estrutura'>";
                                                        echo "<table class='tabela-pedido-cabecalho' width=100%;>";
                                                        echo "<tr>";
                                                        echo "<td style='width:60%;'><strong>Cliente:</strong> ".$nome."</td>";
                                                        echo "<td><strong>Tel:</strong> ".$telefone."</td>";   
                                                        echo "<td style='text-align:right; font-size:20px;'><strong>Ticket Nº: ".$orcamento."</strong></td>";
                                                        echo "</tr>";
                                                        echo "</table>"; 
                                                        

                                                        $sql = "SELECT a.orcamento, b.c_produto, c.d_produto, b.quantidade, b.observacao
                                                        FROM tb_log_delivery a, tb_orcamento b, tb_produto c
                                                        WHERE a.orcamento = '$orcamento'
                                                        AND b.c_gondola = '96'
                                                        AND b.pedido = 'N'
                                                        AND a.orcamento = b.orcamento
                                                        AND b.c_produto = c.c_produto";

                                                        $sql = $pdo->query($sql);

                                                        if($sql->rowCount() > 0) {
                                                            foreach($sql->fetchAll() as $lista) {     
                                                            
                                                            echo "<table width=100%;>";
                                                            echo "<tr>";
                                                            echo "<td style='width:10%;'>".$lista['orcamento']."</td>";
                                                            echo "<td style='width:10%;'>".$lista['c_produto']."</td>";
                                                            echo "<td style='width:10%;'>".$lista['d_produto']."</td>";
                                                            echo "<td style='width:10%;'>".$lista['quantidade']."</td>";
                                                            echo "<td style='width:10%;'>".$lista['observacao']."</td>";
                                                            echo "</tr>";
                                                            echo "</table>";  
                                                            }
                                                        } 

                                                        echo "<div class='botao-acougue'>
                                                            <form name='teste' method='GET' action='delivery.processo.php'>

                                                                <input value=".$orcamento." class='liberar' type='hidden' name='liberarAcougue'>  
                                                                <input value='Liberar' class='liberar' type='submit'>                                                      
                                                            </form>
                                                        </div>"; 
                                                    echo "</div>";                                               
                                                    echo "<hr>"; 
                                                }                                                    
                                                        
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