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
        <title>Catalogo de Endereço</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/endereco.css">
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
                                        <form class="busca-area margin-baixo" name="buscar-form" method="POST">
                                            <input class="input-busca-produto" type="text" autocomplete="off" name="pesquisa" placeholder="Digite o endereço">
                                            <input class="input-botao" type="submit" name="botao-pesquisar" value="Pesquisar">
                                        </form>
                                        <form class="busca-area" name="buscar-form" method="POST" action="endereco.painel2.php">
                                            <input class="input-botao" type="submit" name="" value="Adicionar">
                                        </form>
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Cep</th>
                                                <th style="width:10%;">Cidade/Estado</th>
                                                <th style="width:10%;">Bairro</th>
                                                <th style="width:10%;">Logradouro</th>
                                                <th style="width:10%;">Complemento</th>
                                                <th style="width:10%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php

                                                if(isset($_POST['pesquisa']) && empty($_POST['pesquisa']) == false) { //se existir/ e ele nao estiver vazio.

                                                    $pesquisa = addslashes($_POST['pesquisa']);
                                                    $sql = "SELECT * FROM tb_endereco WHERE logradouro LIKE '%".$pesquisa."%' LIMIT 10";
                                                    
                                                    $sql = $pdo->query($sql); 
 
                                                    if($sql->rowCount() > 0) {
                                                        foreach($sql->fetchAll() as $endereco) {

                                                            echo "<tr>";
                                                            echo "<td style='width:10%;'>".$endereco['cep']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['cidadeEstado']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['bairro']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['logradouro']."</td>";
                                                            echo "<td style='width:10%;'>".$endereco['nomeEdificio']."</td>";                                 
                                                            echo '<td style="width:10%;"><a href="endereco.excluir.php?id='.$endereco['id'].'">Excluir</a>';
                                                            echo "</tr>";  
                                                        }
                                                    }
                                                
                                                } else {   

                                                    echo "Nenhum endereço encontrado.";
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