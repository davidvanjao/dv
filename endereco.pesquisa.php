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
        <title>Pesquisar Endereço</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/pesquisa.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">

                <div class="conteudo-Central">
                    <div class="corpo">
                        <header class="desktop_header">
                            <div class="logo">
                                <img src="">
                            </div>
                            <div class="superiorMenu">
                                <a href="entrega.painel.php">voltar ao formulario de entrega</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-busca">
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar-form" method="POST">
                                            <input class="input-busca-produto" type="text" autocomplete="off" name="endereco" placeholder="Digite o endereço">
                                            <input class="input-botao" type="submit" name="botao-pesquisar" value="Pesquisar">
                                        </form>
                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Cep</th>
                                                <th style="width:10%;">Cidade/Estado</th>
                                                <th style="width:10%;">Bairro</th>
                                                <th style="width:10%;">Logradouro</th>
                                                <th style="width:10%;">Complemento</th>
                                                <th style="width:10%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>
                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php
                                                if(isset($_POST['endereco']) && empty($_POST['endereco']) == false) { //se existir/ e ele nao estiver vazio.

                                                    $endereco = addslashes($_POST['endereco']);

                                                    $sql = "SELECT * FROM tb_endereco
                                                    WHERE logradouro LIKE '%".$endereco."%'";
                                                    
                                                    $sql = $pdo->query($sql);   

                                                    if($sql->rowCount() > 0) {
                                                        foreach($sql->fetchAll() as $endereco) {

                                                            echo "<tr>";
                                                            echo "<td style='width:10%;'>".$endereco['cep']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['cidadeEstado']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['bairro']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['logradouro']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['nomeEdificio']."</td>";                                 
                                                            echo '<td style="width:10%;"><a href="entrega.painel2.php?id='.$endereco['id'].'">adicionar</a>';
                                                            echo "</tr>";  
                                                        }
                                                    } else {
                                                        echo "Nenhum resultado!";
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