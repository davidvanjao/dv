<?php

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <!--<link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/index.css">-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <div class="painel-menu-menu">

            <?php if($usuarios->temPermissao('ADMINISTRADOR')): ?>
                <div class="painel-menu-widget">
                    <a href="produto.painel.pesquisa.php">
                        <img src="assets/img/lupa.png" title="Pesquisar Produto">                                        
                    </a>                        
                </div>
            <?php endif; ?>        

            <?php if($usuarios->temPermissao('USUARIO')): ?>
                <div class="painel-menu-widget">
                    <a href="delivery.painel.1.php">
                        <img src="assets/img/delivery2.png" title="Lista de Compras">                                        
                    </a>                        
                </div>
            <?php endif; ?>

            <?php if($usuarios->temPermissao('USUARIO')): ?>
                <div class="painel-menu-widget">
                    <a href="cesta-basica.painel.1.php">
                        <img src="assets/img/cesta-basica.png" title="Lançamento de Cesta Básica">                                        
                    </a>                        
                </div>
            <?php endif; ?>  

            <?php if($usuarios->temPermissao('USUARIO')): ?>
                <div class="painel-menu-widget">
                    <a href="acougue.painel.1.php">
                        <img src="assets/img/acougue.png" title="Pedidos Açougue">                                        
                    </a>                        
                </div>
            <?php endif; ?>  

            <?php if($usuarios->temPermissao('USUARIO')): ?>
                <div class="painel-menu-widget">
                    <a href="entrega.painel.1.php">
                        <img src="assets/img/entrega.png" title="Lançamento de Entrega">                                        
                    </a>                        
                </div>
            <?php endif; ?>   

            <?php if($usuarios->temPermissao('USUARIO')): ?>
                <div class="painel-menu-widget">
                    <a href="endereco.painel.1.php">
                        <img src="assets/img/endereco.png" title="Lista de Endereços">                                        
                    </a>                        
                </div>
            <?php endif; ?>                    

            <?php if($usuarios->temPermissao('USUARIO')): ?>
                <div class="painel-menu-widget">
                    <a href="cadastro.cliente.painel.1.php">
                        <img src="assets/img/usuario.png" title="Lista de Clientes">                                        
                    </a>                        
                </div>
            <?php endif; ?> 

            <?php if($usuarios->temPermissao('USUARIO')): ?>
                <div class="painel-menu-widget">
                    <a href="configuracao.painel.php">
                        <img src="assets/img/config.png" title="Configuração">                                        
                    </a>                        
                </div>
            <?php endif; ?>
            
        </div>
                            
                        
    </body>


</html>