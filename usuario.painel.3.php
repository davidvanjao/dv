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

//===========================MOSTRAR USUARIO===================================

if(isset($_GET['id'])) {

    $id = addslashes($_GET['id']);

    $sql = "SELECT * FROM tb_usuarios WHERE id = $id";
    $sql = $pdo->query($sql);   

    if($sql->rowCount() > 0) {

        $usuario = $sql->fetch();

        
    }

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
                                        <form method="POST" action="usuario.processo.php">

                                            <label for="email">Nome</label>
                                            <input type="text" value="<?php echo $usuario['nome'];?>" name="nome" id="nome" placeholder="Digite seu nome completo">
                                            <label for="email">Sobrenome</label>
                                            <input type="text" value="<?php echo $usuario['nome'];?>" name="usuario" id="usuario" placeholder="Digite seu usuário">
                                            <label for="senha">Senha</label>
                                            <input type="password" value="<?php echo $usuario['senha'];?>" name="senha" id="senha" placeholder="Digite sua senha">

                                            <input type="hidden" value="<?php echo $id; ?>" name="id">

                                            <div class="checkbox">

                                            <label for="senha">Permissão</label><br>
                                            <input type="checkbox" name="permissao[]" value="USUARIO">Usuário
                                            <input type="checkbox" name="permissao[]" value="ADMINISTRADOR">Administrador

                                        
                                            
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