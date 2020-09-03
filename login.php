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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/styleLogin.css">
    </head>
    <body>
        <div class="body">
            <div class="painel-menu">

                <div class="container">	
                    <form method="POST" class="form-Login">

                        <h2 class="form-Login-cabecalho">Área para Usuário Cadastrado</h2>                                           
                        <input class="form-Login-input" type="text" name="usuario" placeholder="Digitar o Usuário" autofocus><br />      
                        <input class="form-Login-input" type="password" name="senha" placeholder="Digite a Senha">                       
                        <button class="form-Login-button" type="submit" name="btnLogin" >Acessar</button>
                    </form>		
                </div>    

            </div>
            <div class="footer">
                <h2>Desenvolvido por <strong>David Vanjão</strong></h2>
            </div>
        </div>    
    </body>
</html>