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
                            
                            
                        </div>
                    </div>
                </div>
                <div class="content">
                    <header class="desktop_header">
                        <div class="logo">
                            <img src="">
                        </div>
                        <div class="superiorMenu">
                            <a href="sair.php">Fazer Logoff</a>
                        </div>
                    </header>
                    <section class="page">
                        <div class="conteudo color-conteudo ajuste-conteudo">

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
                                        
                                        <?php require 'configuracao.processo.php';?>              
                                        
                                    </div>                
                                </div>                                
                            </div>   

                        </div> 
                    </section>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="assets/js/script.js"></script>
    </body>


</html>