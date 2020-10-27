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
        <title>Tela de Login</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/cadastro.usuario.css">
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
                                <a href=""></a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral alinhar-centro semCorFundo">


                                <div class="login_box">
                                    <div class="login__leftside">
                                        <form method="POST" action="usuario.adicionar.php">
                                            <label for="email">Nome</label>
                                            <input type="text" name="nome" id="nome" autocomplete="off" placeholder="Digite seu nome completo">
                                            <label for="email">Usuário</label>
                                            <input type="text" name="usuario" id="usuario" autocomplete="off" placeholder="Digite seu usuário">
                                            <label for="senha">Senha</label>
                                            <input type="password" name="senha" id="senha" autocomplete="off" placeholder="Digite sua senha">

                                            <div class="checkbox">

                                            <label for="senha">Permissão</label><br>
                                            <input type="checkbox" name="permissao[]" value="USUARIO" checked>Usuário
                                            <input type="checkbox" name="permissao[]" value="USUARIO,ADMINISTRADOR">Administrador
                                            
                                            </div>  

                                            <input type="submit" name="btnCadastar" value="Cadastar">
                                        </form>

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