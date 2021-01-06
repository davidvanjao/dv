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

if($usuarios->temPermissao('ENT') == false) {
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
        <link rel="stylesheet" href="assets/css/entrega.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">
            
                        <div class="painel-menu-menu">
        
                        <?php require 'menuLateral.php'; ?>
                            
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
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">

                                        <form class="cesta-area" id="cesta-area" name="buscar-form" method="POST" action="entrega.endereco.pesquisa.php">
                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar">
                                        </form>
                                        
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Data</th>
                                                <th style="width:10%;">Cidade</th>
                                                <th style="width:20%;">Endereço</th>
                                                <th style="width:5%;">Compra</th>
                                                <th style="width:5%;">Caixas</th>
                                                <th style="width:5%;">Valor</th>
                                                <th style="width:10%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php
                                                $sql = "SELECT *, DATE_FORMAT(dataa, '%d/%m/%Y') as saida_data FROM tb_entrega";
                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $entrega) {


                                                        echo "<tr>";
                                                        echo "<td style='width:10%;'>".$entrega['saida_data']."</td>";
                                                        echo "<td style='width:10%;'>".$entrega['cidadeEstado']."</td>";
                                                        echo "<td style='width:20%;'>".$entrega['logradouro']."</td>";                                                         
                                                        echo "<td style='width:5%;'>".$entrega['compra']."</td>"; 
                                                        echo "<td style='width:5%;'>".$entrega['nCaixas']."</td>"; 
                                                        echo "<td style='width:5%;'>R$ ".$entrega['valor']."</td>";                                  
                                                        echo '<td style="width:10%;"><a href="entrega.processo.php?id='.$entrega['id'].'">Excluir</a>';
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