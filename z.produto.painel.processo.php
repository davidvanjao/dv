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

if($usuarios->temPermissao('CONF') == false) {
    header("Location:index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Configuração</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/configuracao.css">
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
                                <a href="produto.painel.processo.php">Carregar Produtos</a>
                                <a href="endereco.processo-externo.php">Carregar Enderecos</a>
                                <a href="">Peinel 3</a>
                                <a href="">Painel 4</a>
                                <a href="usuario.painel.php">Painel de Usuários</a>
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-busca">
                                    <div class="painel-Importacao">
                                        <div class="controle">

                                            <div class="painel-botao">
                                                <input type="submit" value="Iniciar" id="botao_iniciar" onclick="iniciarAtualizar()">
                                                <input type="submit" value="Parar" id="botao_parar" onclick="pararAtualizar()">
                                            </div>
                                            <div class="painel-relogio">
                                                <span id="spanRelogio">00:00</span>                                        
                                            </div>
                                        
                                        
                                        
                                        </div>

                                        
                                        

                                        <div class="conteiner-resultado">
                                            
                                            <?php require 'produto.processo-externo.php';?>      
                                            
                                        </div>                
                                    </div>                                
                                </div>   

                            </div> 
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="assets/js/script.js"></script>
    </body>


</html>