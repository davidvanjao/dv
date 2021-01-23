            <?php if($usuarios->temPermissao('PES')): ?>
                <div class="painel-menu-widget">
                    <a href="produto.painel.pesquisa.php" name="teste">
                        <img src="assets/img/lupa.png" title="Pesquisar Produto">                                        
                    </a>                        
                </div>
            <?php endif; ?>        

            <?php if($usuarios->temPermissao('ORC')): ?>
                <div class="painel-menu-widget">
                    <a href="orcamento.painel.1.php">
                        <img src="assets/img/orcamento.png" title="Orçamento">                                        
                    </a>                        
                </div>
            <?php endif; ?>

            <?php if($usuarios->temPermissao('DEL')): ?>
                <div class="painel-menu-widget">
                    <a href="delivery.painel.1.php">
                        <img src="assets/img/delivery2.png" title="Lista de Compras">                                        
                    </a>                        
                </div>
            <?php endif; ?>

            <?php if($usuarios->temPermissao('CES')): ?>
                <div class="painel-menu-widget">
                    <a href="cesta-basica.painel.1.php">
                        <img src="assets/img/cesta-basica.png" title="Lançamento de Cesta Básica">                                        
                    </a>                        
                </div>
            <?php endif; ?>  

            <?php if($usuarios->temPermissao('ACO')): ?>
                <div class="painel-menu-widget">
                    <a href="acougue.painel.1.php">
                        <img src="assets/img/acougue.png" title="Pedidos Açougue">                                        
                    </a>                        
                </div>
            <?php endif; ?>  

            <?php if($usuarios->temPermissao('ENT')): ?>
                <div class="painel-menu-widget">
                    <a href="entrega.painel.1.php">
                        <img src="assets/img/entrega.png" title="Lançamento de Entrega">                                        
                    </a>                        
                </div>
            <?php endif; ?>   

            <?php if($usuarios->temPermissao('END')): ?>
                <div class="painel-menu-widget">
                    <a href="endereco.painel.1.php">
                        <img src="assets/img/endereco.png" title="Lista de Endereços">                                        
                    </a>                        
                </div>
            <?php endif; ?>                    

            <?php if($usuarios->temPermissao('CLI')): ?>
                <div class="painel-menu-widget">
                    <a href="cliente.painel.pesquisa.php">
                        <img src="assets/img/usuario.png" title="Lista de Clientes">                                        
                    </a>                        
                </div>
            <?php endif; ?> 

            <?php if($usuarios->temPermissao('CON')): ?>
                <div class="painel-menu-widget">
                    <a href="configuracao.painel.php">
                        <img src="assets/img/config.png" title="Configuração">                                        
                    </a>                        
                </div>
            <?php endif; ?>

            <?php if($usuarios->temPermissao('CON')): ?>
                <div class="painel-menu-widget">
                    <a href="teste.php">
                        <img src="assets/img/novo.png" title="Configuração">                                        
                    </a>                        
                </div>
            <?php endif; ?>
