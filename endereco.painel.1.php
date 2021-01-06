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

if($usuarios->temPermissao('END') == false) {
    header("Location:index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Catalogo de Endereço</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/endereco.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">
            
                        <div class="painel-menu-menu">
        
                        <?php require 'menuLateral.php'; ?>
                            
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

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        <form class="form-cesta-2" name="buscar-form" method="POST">
                                            <input class="input-busca-produto" minlength="3" type="text" autocomplete="off" name="pesquisa" placeholder="Digite o endereço">
                                            <input class="input-botao" type="submit" name="botao-pesquisar" value="Pesquisar">
                                        </form>
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:5%;">Cep</th>
                                                <th style="width:10%;">Cidade</th>
                                                <th style="width:10%;">Bairro</th>
                                                <th style="width:20%;">Logradouro</th>
                                                <th style="width:10%;">Compl</th>
                                                <th style="width:5%;">Região</th>
                                                <th style="width:5%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php

                                                if(isset($_POST['pesquisa']) && empty($_POST['pesquisa']) == false) { //se existir/ e ele nao estiver vazio.

                                                    $pesquisa = addslashes($_POST['pesquisa']);
                                                    $sql = "SELECT * FROM tb_endereco WHERE logradouro LIKE '%".$pesquisa."%' LIMIT 30";
                                                    
                                                    $sql = $pdo->query($sql); 
 
                                                    if($sql->rowCount() > 0) {
                                                        foreach($sql->fetchAll() as $endereco) {

                                                            echo "<tr>";
                                                            echo "<td style='width:5%;'>".$endereco['cep']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['cidadeEstado']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['bairro']."</td>";
                                                            echo "<td style='width:20%;'>".$endereco['logradouro']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['nomeEdificio']."</td>";
                                                            echo "<td style='width:5%;'>".$endereco['regiao']."</td>";                                 
                                                            echo '<td style="width:5%;"><a href="endereco.processo.php?id='.$endereco['id'].'">Excluir</a>';
                                                            echo "</tr>";  
                                                        }
                                                    }
                                                
                                                } else {   

                                                    echo "Nenhum endereço localizado.";
                                                }
                                                ?>                                             

                                            </table>
                                        </div>
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