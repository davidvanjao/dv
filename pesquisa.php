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
        <title>Pesquisar Produtos</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/tabela_Pesquisa.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="body">
            <div class="painel-menu">

                <div class="body-busca">
                    <form class="busca-area" name="buscar-form" method="POST">
                        <input class="input-busca-produto" type="text" name="pesquisa" placeholder="Digite o nome do produto">
                        <input class="input-busca-codigo" type="text" name="codigo" placeholder="Cód. do Produto">
                        <input class="input-botao" type="submit" name="botao-pesquisar" value="Pesquisar">
                    </form>
                    <div class="tabela-titulo">
                        <table>
                            <tr>
                                <th style="width:10%;">Código</th>
                                <th style="width:50%;">Produto</th>
                                <th style="width:10%;">Preço</th>
                                <th style="width:10%;">Estoque</th>
                            </tr>
                        </table> 
                    </div>
                    
                    <div class="busca-resultado"> 
                        <table>
                            <?php
                                if(isset($_POST['pesquisa']) && empty($_POST['pesquisa']) == false) { //se existir/ e ele nao estiver vazio.

                                    $pesquisa = addslashes($_POST['pesquisa']);
                                    $sql = "SELECT * FROM produto WHERE prod_valor !='0' AND prod_produto LIKE '%".$pesquisa."%'";
                                    $sql = $pdo->query($sql);                                    

                                    if($sql->rowCount() > 0) {
                                        foreach($sql->fetchAll() as $produto) {
                                            echo "<tr>";
                                            echo "<td style='width:10%;'>".$produto['prod_ean']."</td>";
                                            echo "<td style='width:50%;'>".$produto['prod_produto']."</td>";
                                            echo "<td style='width:20%;'>R$ ".$produto['prod_valor']."</td>";
                                            echo "<td style='width:10%;'>".$produto['prod_estoque']."</td>";
                                            echo "</tr>";  
                                        }
                                    } 
                                }
                                if(isset($_POST['codigo']) && empty($_POST['codigo']) == false) { //se existir/ e ele nao estiver vazio.

                                    $codigo = addslashes($_POST['codigo']);
                                    $sql = "SELECT * FROM produto WHERE prod_ean = $codigo";
                                    $sql = $pdo->query($sql);                                    

                                    if($sql->rowCount() > 0) {
                                        foreach($sql->fetchAll() as $produto) {

                                            echo "<tr>";
                                            echo "<td style='width:10%;'>".$produto['prod_ean']."</td>";
                                            echo "<td style='width:50%;'>".$produto['prod_produto']."</td>";
                                            echo "<td style='width:20%;'>R$ ".$produto['prod_valor']."</td>";
                                            echo "<td style='width:10%;'>".$produto['prod_estoque']."</td>";
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
            <div class="footer">
                <h2>Desenvolvido por <strong>David Vanjão</strong></h2>
            </div>

        </div>
        <!--<script type="text/javascript" src="assets/js/atualizar.js"></script>-->        
        <!--<script type="text/javascript" src="assets/js/painel.js"></script>-->
    </body>
</html>