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

if($usuarios->temPermissao('CON') == false) {
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
                                <a href="usuario.painel.1.php">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral alinhar-centro semCorFundo">


                                <div class="login_box">
                                    <div class="login__leftside">
                                        <form method="POST" action="usuario.processo.php">
                                            <label for="email">Nome</label>
                                            <input type="text" name="nome" style="text-transform: uppercase;" id="nome" autocomplete="off" placeholder="Digite seu primeiro nome">
                                            <label for="email">Sobrenome</label>
                                            <input type="text" name="sobrenome" style="text-transform: uppercase;" id="nome" autocomplete="off" placeholder="Digite seu sobrenome">

                                            <label for="senha">Senha</label>
                                            <input type="password" name="senha" id="senha" autocomplete="off" placeholder="Digite sua senha">

                                            <div class="checkbox">

                                                <H3>Permissões</H3><br>
                                                    <?php
                                                    $sql = "SELECT * FROM tb_permissao";
                                                    $sql = $pdo->query($sql);   
                                                    if($sql->rowCount() > 0) {
                                                        foreach($sql->fetchAll() as $permissao) {
                                                            ?>
                                                            <input type="checkbox" name="permissao[]" value="<?php echo $permissao['permissao']; ?>"> <?php echo $permissao['descricao']; ?><br>
                                                            <?php
                                                        }
                                                    } else {
                                                            
                                                            echo "Nenhuma permissão encontrada.";
                                                        }
                                                    ?> 

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