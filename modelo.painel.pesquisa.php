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

                                <div class="body-busca">
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar-form" method="POST">
                                            <input class="input-busca-produto" minlength="3" type="text" autocomplete="off" name="pesquisa" placeholder="Digite o nome do produto">
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
                                                <th style="width:10%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php
                                                if(isset($_POST['pesquisa']) && empty($_POST['pesquisa']) == false) { //se existir/ e ele nao estiver vazio.

                                                    $pesquisa = addslashes($_POST['pesquisa']);
                                                    $sql = "SELECT * FROM tb_produto
                                                    WHERE preco !='0' AND d_produto LIKE '".$pesquisa."%'";
                                                    
                                                    $sql = $pdo->query($sql);                                    

                                                    if($sql->rowCount() > 0) {
                                                        foreach($sql->fetchAll() as $produto) {
                                                            echo "<tr>";
                                                            echo "<td style='width:10%;'>".$produto['c_produto']."</td>";
                                                            echo "<td style='width:50%;'>".$produto['d_produto']."</td>";
                                                            echo "<td style='width:20%;'>R$ ".$produto['preco']."</td>";
                                                            echo "<td style='width:10%;'>".$produto['estoque']."</td>";
                                                            echo '<td style="width:10%;"><a href="modelo.painel.2.php?adicionar='.$produto['id'].'">Add</a>';
                                                            echo "</tr>";  
                                                        }
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