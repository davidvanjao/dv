<?php

session_start();
require 'conexao.php';
require 'classes/usuarios.class.php';

if(!empty($_POST['usuario'])) {
    $usuario = addslashes($_POST['usuario']);
    $senha = addslashes($_POST['senha']);

    $usuarios = new Usuarios($pdo);

    if($usuarios->fazerLogin($usuario, $senha)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Usuário ou senha incorretos!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Login</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/login.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="content">
                    <header class="desktop_header">
                        <div class="logo">
                            <img src="">
                        </div>
                        <div class="superiorMenu">
                            <a href=""></a>
                        </div>
                    </header>
                    <section class="page">
                        <div class="conteudo">
                            <div class="login_box">
                                <div class="login__leftside">
                                    <form method="POST">
                                        <label for="email">Usuário</label>
                                        <input type="text" name="usuario" id="usuario" placeholder="Digite seu usuário">
                                        <label for="senha">Senha</label>
                                        <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
                                        <input type="submit" name="btnLogin" value="Entrar">
                                    </form>
                                    <div class="social">
                                        "Nos acompanhe em nossas redes sociais"
                                        <div class="socialinks">
                                            <a href="">
                                                <img src="assets/img/whats.png">
                                            </a>
                                            <a href="">
                                                <img src="assets/img/tel.png">
                                            </a>
                                            <a href="">
                                                <img src="assets/img/whats.png">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="login__rightsite">
                                    <div class="itemArea">
                                        <img src="assets/img/logo.png">
                                    </div>
                                </div>
    
                            </div>                            
                        </div>
                        
                    </section>
                </div>
            </div>
        </div>

    </body>


</html>