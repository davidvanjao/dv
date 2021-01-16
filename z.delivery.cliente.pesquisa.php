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

if($usuarios->temPermissao('DEL') == false) {
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
        <link rel="stylesheet" href="assets/css/delivery.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                    </div>
                </div>

                <div class="conteudo-Central">
                    <div class="corpo">
                        <header class="desktop_header">
                            <div class="logo">
                                <img src="">
                            </div>
                            <div class="superiorMenu">
                                <a href="delivery.painel.1.php">Voltar</a>

                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">

                                        <form class="busca-area" name="buscar-form" method="POST">
                                            <input class="input-busca-produto" type="text" autocomplete="off" name="cliente" placeholder="Digite o cliente">
                                            <input class="input-botao" type="submit" name="pesquisar" value="Pesquisar Cliente">
                                        </form>
                                        
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Nome</th>
                                                <th style="width:10%;">Telefone</th>
                                                <th style="width:10%;">Cidade</th>
                                                <th style="width:10%;">Endereço</th>
                                                <th style="width:10%;">Numero</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="busca-resultado">
                                            <table>
                                                <?php

                                                    if(isset($_POST['cliente']) && empty($_POST['cliente']) == false) { //se existir/ e ele nao estiver vazio.

                                                        $cliente = addslashes($_POST['cliente']);

                                                        $sql = "SELECT a.id, a.nome, a.telefone, b.cidadeEstado, b.bairro, b.logradouro, a.numero, b.regiao
                                                        from tb_cliente a, tb_endereco b
                                                        WHERE a.nome LIKE '%".$cliente."%' 
                                                        AND a.idEndereco = b.id 
                                                        order by a.nome";
                                                        
                                                        $sql = $pdo->query($sql);   

                                                        if($sql->rowCount() > 0) {
                                                            foreach($sql->fetchAll() as $cliente) {

                                                                echo '<tr ondblclick=location.href="delivery.processo.php?cliente='.$cliente['id'].'" style="cursor:pointer">';
                                                                echo "<td style='width:10%;'>".$cliente['nome']."</td>";
                                                                echo "<td style='width:10%;'>".$cliente['telefone']."</td>";
                                                                echo "<td style='width:10%;'>".$cliente['cidadeEstado']."</td>";
                                                                echo "<td style='width:10%;'>".$cliente['logradouro']."</td>";  
                                                                echo "<td style='width:10%;'>".$cliente['numero']."</td>";                               
                                                                echo "</tr>";  
                                                            }
                                                        } else {

                                                            echo "Nenhum resultado!";
                                                        }
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