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
        
                        <div class="painel-menu-menu">
        
                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="produto.painel.pesquisa.php">
                                        <img src="assets/img/lupa.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>      

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="delivery.painel.1.php">
                                        <img src="assets/img/delivery.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>  

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="cesta-basica.painel.php">
                                        <img src="assets/img/cesta-basica.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>  

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="endereco.painel.1.php">
                                        <img src="assets/img/endereco.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>       

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="entrega.painel.1.php">
                                        <img src="assets/img/entrega.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>    

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="cliente.painel.1.php">
                                        <img src="assets/img/usuario.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?> 

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="configuracao.painel.php">
                                        <img src="assets/img/config.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>
                            
                        </div>
                            
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

                                <div class="body-busca">
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar-form" method="POST">
                                            <input class="input-busca-produto" minlength="3" type="text" autocomplete="off" name="pesquisa" placeholder="Digite o nome do produto">
                                            <input class="input-busca-codigo" type="number" autocomplete="off" name="codigo" placeholder="Cód. do Produto">
                                            <input class="input-botao" type="submit" name="botao-pesquisar" value="Pesquisar">
                                        </form>
                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Código</th>
                                                <th style="width:50%;">Produto</th>
                                                <th style="width:20%;">Preço</th>
                                                <th style="width:10%;">Estoque</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php
                                                if(isset($_POST['pesquisa']) && empty($_POST['pesquisa']) == false) { //se existir/ e ele nao estiver vazio.

                                                    $pesquisa = addslashes($_POST['pesquisa']);

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
                                                    ORDER BY a.seqproduto";
                                                    
                                                    //prepara uma instrucao para execulsao
                                                    $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                                    //Executa os comandos SQL
                                                    $exec = oci_execute($resultado);

                                                    foreach($exec as $value) {
                                                        var_dump($value);
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