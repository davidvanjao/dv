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

                                        <form class="cesta-area" id="cesta-area" name="buscar-form" method="POST" action="endereco.pesquisa.cliente.php">
                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar">
                                        </form>
                                        
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Nome</th>
                                                <th style="width:10%;">Telefone</th>
                                                <th style="width:10%;">Cidade</th>
                                                <th style="width:10%;">Bairro</th>
                                                <th style="width:10%;">Endereço</th>
                                                <th style="width:10%;">Numero</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php

                                                $sql = "SELECT a.nome, a.telefone, b.cidadeEstado, b.bairro, b.logradouro, a.numero 
                                                from tb_cliente as a join tb_endereco as b 
                                                on a.idEndereco = b.id 
                                                order by a.nome";

                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $cliente) {

                                                        echo "<tr>";
                                                        echo "<td style='width:10%;'>".$cliente['nome']."</td>";
                                                        echo "<td style='width:10%;'>".$cliente['telefone']."</td>";
                                                        echo "<td style='width:10%;'>".$cliente['cidadeEstado']."</td>";
                                                        echo "<td style='width:10%;'>".$cliente['bairro']."</td>";
                                                        echo "<td style='width:10%;'>".$cliente['logradouro']."</td>";  
                                                        echo "<td style='width:10%;'>".$cliente['numero']."</td>";                               
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