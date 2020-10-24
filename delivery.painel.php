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
        <title>Tela de Entrega</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/cesta-basica.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">
            
                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="produto.pesquisa.php">
                                        <img src="assets/img/lupa2.svg">
                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>        

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="produto.adicionar.php">
                                        <img src="assets/img/engrenagem2.svg">
                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="cesta-basica.painel.php">
                                        <img src="assets/img/cestabasica.png">
                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>  

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="endereco.painel.php">
                                        <img src="assets/img/endereco.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>       

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="entrega.painel.php">
                                        <img src="assets/img/caminhao.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>    
                            
                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="cartaz-preco.painel.php">
                                        <img src="assets/img/cartazPreco.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?> 

                            <?php if($usuarios->temPermissao('USUARIO')): ?>
                                <div class="painel-menu-widget">
                                    <a href="usuario.painel.php">
                                        <img src="assets/img/user.png">                                        
                                    </a>                        
                                </div>
                            <?php endif; ?> 
                            
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
                                <a href="sair.php">Fazer Logoff</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-cesta">
                                    <div class="campo-inserir">

                                        <form class="cesta-area" id="cesta-area" name="buscar-form" method="POST" action="cliente.pesquisa.php">
                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar">
                                        </form>
                                        
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:05%;">Ticket</th>
                                                <th style="width:10%;">Data</th>
                                                <th style="width:10%;">Nome</th>
                                                <th style="width:10%;">Cidade</th>
                                                <th style="width:10%;">Endereço</th>
                                                <th style="width:10%;">Numero</th>
                                                <th style="width:10%;">Status</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php

                                                $sql = "SELECT a.id, a.dataa, b.nome, c.cidadeEstado, c.logradouro, b.numero, a.statuss
                                                from tb_log_delivery as a join tb_cliente as b join tb_endereco as c 
                                                on a.idCliente = b.id 
                                                and b.idEndereco = c.id
                                                order by a.id";

                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $delivery) {

                                                        echo "<tr>";
                                                        echo "<td style='width:5%;'>".$delivery['id']."</td>";
                                                        echo "<td style='width:10%;'>".$delivery['dataa']."</td>";
                                                        echo "<td style='width:10%;'>".$delivery['nome']."</td>";
                                                        echo "<td style='width:10%;'>".$delivery['cidadeEstado']."</td>";
                                                        echo "<td style='width:10%;'>".$delivery['logradouro']."</td>";  
                                                        echo "<td style='width:10%;'>".$delivery['numero']."</td>";     
                                                        echo "<td style='width:10%;'>".$delivery['statuss']."</td>";                           
                                                        echo "</tr>";  

                                                    
                                                    }
                                                } else {
                                                        
                                                        echo "Nenhum produto encontrado.";
                                                    }
                                                ?>                                             

                                            </table>
                                        </div>
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