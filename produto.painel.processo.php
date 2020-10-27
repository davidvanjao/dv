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
                                <a href="sair.php">Fazer Logoff</a>
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