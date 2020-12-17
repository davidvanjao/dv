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
        <title>Cadastro de Usuários</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/usuario.css">
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
                                <a href="usuario.painel.php">Painel de Usuários</a>
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        
                                        <form class="cesta-area" id="cesta-area" name="buscar-form" method="POST" action="usuario.painel.2.php">
                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar">
                                        </form>

                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Id</th>
                                                <th style="width:10%;">Nome</th>
                                                <th style="width:10%;">Usuário</th>
                                                <th style="width:10%;">Permições</th>
                                                <th style="width:10%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php
                                                $sql = "SELECT * FROM tb_usuarios ORDER BY nome";
                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $usuario) {

                                                        echo "<tr>";
                                                        echo "<td style='width:10%;'>".$usuario['id']."</td>";
                                                        echo "<td style='width:10%;'>".$usuario['nome']."</td>";
                                                        echo "<td style='width:10%;'>".$usuario['usuario']."</td>";
                                                        echo "<td style='width:10%;'>".$usuario['permissao']."</td>";                                
                                                        echo '<td style="width:10%;"><a href="usuario.painel.3.php?id='.$usuario['id'].'">Editar</a>';
                                                        echo "</tr>";  
                                                    }
                                                } else {
                                                        
                                                        echo "Nenhum produto encontrado.";
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