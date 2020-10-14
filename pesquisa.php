<?php

session_start();
require 'conexao.php';
require 'classes/usuarios.class.php';


if (isset($_SESSION['logado']) && empty($_SESSION['logado']) == false) {
} else {
    header("Location: login.php");
}

$usuarios = new Usuarios($pdo);
$usuarios->setUsuario($_SESSION['logado']);

if($usuarios->temPermissao('PES') == false) {
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
        
                            <?php if($usuarios->temPermissao('PES')): ?>
                                <div class="painel-menu-widget">
                                    <a href="pesquisa.php">
                                        <img src="assets/img/lupa2.svg">
                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>        
        
                            <?php if($usuarios->temPermissao('CONF')): ?>
                                <div class="painel-menu-widget">
                                    <a href="configuracao.php">
                                        <img src="assets/img/engrenagem2.svg">
                                        
                                    </a>                        
                                </div>
                            <?php endif; ?> 

                            <?php if($usuarios->temPermissao('PES')): ?>
                                <div class="painel-menu-widget">
                                    <a href="cesta-basica.php">
                                        <img src="assets/img/lupa2.svg">
                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>    
                            
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
                                <a href="sair.php">Fazer Logoff</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-busca">
                                    <form class="busca-area" name="buscar-form" method="POST">
                                        <input class="input-busca-produto" type="text" autocomplete="off" name="pesquisa" placeholder="Digite o nome do produto">
                                        <input class="input-busca-codigo" type="number" autocomplete="off" name="codigo" placeholder="Cód. do Produto">
                                        <input class="input-botao" type="submit" name="botao-pesquisar" value="Pesquisar">
                                    </form>
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
                                                    $sql = "SELECT * FROM tb_produto
                                                    WHERE preco !='0' AND d_produto LIKE '%".$pesquisa."%'";
                                                    
                                                    $sql = $pdo->query($sql);                                    

                                                    if($sql->rowCount() > 0) {
                                                        foreach($sql->fetchAll() as $produto) {
                                                            echo "<tr>";
                                                            echo "<td style='width:10%;'>".$produto['c_produto']."</td>";
                                                            echo "<td style='width:50%;'>".$produto['d_produto']."</td>";
                                                            echo "<td style='width:20%;'>R$ ".$produto['preco']."</td>";
                                                            echo "<td style='width:10%;'>".$produto['estoque']."</td>";
                                                            echo "</tr>";  
                                                        }
                                                    } 
                                                }
                                                if(isset($_POST['codigo']) && empty($_POST['codigo']) == false) { //se existir/ e ele nao estiver vazio.

                                                    $codigo = addslashes($_POST['codigo']);

                                                    //$sql = "SELECT * FROM tb_produto WHERE c_produto = $codigo";

                                                    $sql = "SELECT * FROM
                                                    tb_produto join tb_codigo
                                                    on tb_produto.c_produto = tb_codigo.c_produto
                                                    where tb_codigo.c_interno LIKE '$codigo'";

                                                    
                                                    $sql = $pdo->query($sql);                                    

                                                    if($sql->rowCount() > 0) {
                                                        foreach($sql->fetchAll() as $produto) {

                                                            echo "<tr>";
                                                            echo "<td style='width:10%;'>".$produto['c_produto']."</td>";
                                                            echo "<td style='width:50%;'>".$produto['d_produto']."</td>";
                                                            echo "<td style='width:20%;'>R$ ".$produto['preco']."</td>";
                                                            echo "<td style='width:10%;'>".$produto['estoque']."</td>";
                                                            echo "</tr>";  
                                                        }
                                                    } else {
                                                        
                                                        echo "<td style='width:10%;'>".$codigo. " Nenhum produto encontrado.</td>";
                                                        //exit;
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