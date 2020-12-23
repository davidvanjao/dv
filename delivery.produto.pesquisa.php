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

if($usuarios->temPermissao('USUARIO') == false) {
    header("Location:index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Pesquisa</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/pesquisa.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">
        

                            
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
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar-form" method="POST">
                                            <input class="input-busca-produto" id="pesquisaModelo" minlength="3" type="text" autocomplete="off" name="pesquisa" placeholder="Digite o nome do produto">
                                            <input class="input-botao" type="submit" name="botao-pesquisar" value="Pesquisar">
                                        </form>
                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Código</th>
                                                <th style="width:50%;">Produto</th>
                                                <th style="width:10%;">Preço</th>
                                                <th style="width:10%;">Promoção</th>
                                                <th style="width:10%;">Estoque</th>
                                                <!--<th style="width:10%;">Ações</th>-->
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado" id="resultado"> 

                                        <table>
                                            <?php
                                                /*if(isset($_POST['pesquisa']) && empty($_POST['pesquisa']) == false) { //se existir/ e ele nao estiver vazio.

                                                    $pesquisa = addslashes($_POST['pesquisa']);
                                                    $sql = "SELECT * FROM tb_produto
                                                    WHERE preco !='0' AND d_produto LIKE '".$pesquisa."%'";
                                                    
                                                    $sql = $pdo->query($sql);                                    

                                                    if($sql->rowCount() > 0) {
                                                        foreach($sql->fetchAll() as $produto) {
                                                            echo '<tr ondblclick=location.href="delivery.processo.php?produto='.$produto['c_produto'].'" style="cursor:pointer">';
                                                            echo "<td style='width:10%;'>".$produto['c_produto']."</td>";
                                                            echo "<td style='width:50%;'>".$produto['d_produto']."</td>";
                                                            echo "<td style='width:20%;'>R$ ".$produto['preco']."</td>";
                                                            echo "<td style='width:10%;'>".$produto['estoque']."</td>";
                                                            //echo '<td style="width:10%;"><a href="modelo.painel.2.php?adicionar='.$produto['c_produto'].'">Add</a>';
                                                            echo '</tr>';  
                                                        }
                                                    } 
                                                }*/

                                                if(isset($_POST['pesquisa']) && empty($_POST['pesquisa']) == false) { //se existir/ e ele nao estiver vazio.

                                                    $pesquisa = addslashes($_POST['pesquisa']);
                                                    $pesquisa = strtoupper($pesquisa);
    
                                                    $consulta = "SELECT a.nroempresa, a.nrogondola, c.gondola, a.seqproduto, b.desccompleta, d.qtdembalagem, a.estqloja, d.codacesso, consinco.fprecoembnormal(a.seqproduto, 1, e.nrosegmentoprinc, a.nroempresa) preco,
                                                    consinco.fprecoembpromoc(a.seqproduto, 1, e.nrosegmentoprinc, a.nroempresa) precoprom
                                                    FROM
                                                    consinco.mrl_produtoempresa a, 
                                                    consinco.map_produto b, 
                                                    consinco.mrl_gondola c,
                                                    consinco.map_prodcodigo d,
                                                    consinco.max_empresa e
                                                    WHERE
                                                    a.nroempresa = '1'
                                                    AND e.nroempresa = '1'
                                                    AND d.qtdembalagem = '1'
                                                    AND a.nrogondola = c.nrogondola
                                                    AND a.seqproduto = b.seqproduto
                                                    AND a.seqproduto = d.seqproduto
                                                    AND d.tipcodigo IN ('E', 'B')
                                                    AND b.desccompleta LIKE '%".$pesquisa."%'
                                                    ORDER BY b.desccompleta";
                                                    
                                                    //prepara uma instrucao para execulsao
                                                    $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");
    
                                                    //Executa os comandos SQL
                                                    oci_execute($resultado);
    
                                                    while (($produto = oci_fetch_array($resultado, OCI_ASSOC)) != false) {

                                                        
    
                                                    echo "<tr>";
                                                    echo '<tr ondblclick=location.href="delivery.processo.php?produto='.$produto['SEQPRODUTO'].'" style="cursor:pointer">';
                                                    echo "<td style='width:10%;'>".$produto['CODACESSO']."</td>";
                                                    echo "<td style='width:50%;'>".$produto['DESCCOMPLETA']."</td>";  
                                                    echo "<td style='width:10%;'>R$ ".number_format($produto['PRECO'],2,",",".")."</td>";   
                                                    if($produto['PRECOPROM'] > 0) {
    
                                                        echo "<td style='width:10%; background-color:#ffff00; font-weight:bold;'>R$ ".number_format($produto['PRECOPROM'],2,",",".")."</td>"; 
    
                                                    } else {                                                    
    
                                                        echo "<td style='width:10%;'>R$ ".number_format($produto['PRECOPROM'],2,",",".")."</td>"; 
                                                    }
    
    
                                                    echo "<td style='width:10%;'>".number_format($produto['ESTQLOJA'],3,".",".")."</td>";      
                                                    
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

        <!--<script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/script3.js"></script>-->

    </body>


</html>