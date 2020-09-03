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

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Painel Administrativo - Tupã/SP</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/painel.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="body">
            <div class="painel-menu">
                <div class="painel-menu-menu">

                    <?php if($usuarios->temPermissao('CAR')): ?>
                        <div class="painel-menu-widget">
                            <a href="#">
                                <img src="assets/image/preco.png">
                                <h1 class="">Cartaz de Preço</h1>
                            </a>                        
                        </div>
                    <?php endif; ?>


                    <?php if($usuarios->temPermissao('PES')): ?>
                        <div class="painel-menu-widget">
                            <a href="pesquisa.php">
                                <img src="assets/image/pesquisa.png">
                                <h1 class="">Pesq. Produto</h1>
                            </a>                        
                        </div>
                    <?php endif; ?>


                    <?php if($usuarios->temPermissao('CONF')): ?>
                        <div class="painel-menu-widget">
                            <a href="importacao.php">
                                <img src="assets/image/configuracaop.png">
                                <h1 class="">Configuração</h1>
                            </a>                        
                        </div>
                    <?php endif; ?>


                    
                </div>
                <div class="painel-menu-modal">
                    <h1>Escolha o Tipo de Cartaz</h1>
                    <div class="painel-menu-widget-escolha">
                        <div class="painel-menu-widget">
                            <a href="assets/paginas/cPequeno.html">
                                <img src="assets/image/placaPreco_Pequeno.png">
                                <h1 class="">Pequeno</h1>
                            </a>
                        </div>
                        <div class="painel-menu-widget">
                            <a href="assets/paginas/cGrande.html">
                                <img src="assets/image/placaPreco_Grande.png">
                                <h1 class="">Grande</h1>
                            </a>
                        </div>
                    </div>
                    <div class="painel-menu-fechar">X</div>
                </div>
                

            </div>
            <div class="footer">
                <h2>Desenvolvido por <strong>David Vanjão</strong></h2>
            </div>

        </div>
        
        <script type="text/javascript" src="assets/js/painel.js"></script>
    </body>
</html>