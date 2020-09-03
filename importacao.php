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
        <title>Painel Administrativo - Tupã/SP</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/sImportacao.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="body">
            <div class="painel-menu">
                <div class="painel-Importacao">

                    <div class="painel-botao">
                        <input type="submit" value="Iniciar" id="botao_iniciar" onclick="iniciarAtualizar()">
                        <input type="submit" value="Parar" id="botao_parar" onclick="pararAtualizar()">
                    </div>
                    
                    <span id="spanRelogio"></span></br></br>

                    <div class="conteiner-resultado">            
                    
                        <?php require 'importacao.processo.php';?>
                    
                    </div>

                </div> 
            </div>
            <div class="footer">
                <h2>Desenvolvido por <strong>David Vanjão</strong></h2>
            </div>

        </div>
        
        <script type="text/javascript" src="assets/js/atualizar.js"></script>
    </body>
</html>