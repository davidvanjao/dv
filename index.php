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

//pegar id da sessao
$nomeUsuario = $_SESSION['logado'];

$sql = "SELECT nome FROM tb_usuarios WHERE id = '$nomeUsuario'";
$sql = $pdo->query($sql);

if($sql->rowCount() > 0) {

    $nome = $sql->fetch();     
    $nome = explode(" ", $nome['nome']); //divide uma string por uma string.

}
var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela do Sistema</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/index.css">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">
        
                        <?php require 'menuLateral.php'; ?>
                            
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
                            <div class="conteudo-Geral semCorFundo alinhar-centro">
                                <h1 style="font-size:100px; color:#fff;">Seja Bem Vindo <?php echo ucfirst($nome[0])?>!</h1>
                            </div> 
                        </section>
                    </div>
                </div>
            
            </div>
        </div>

    </body>


</html>