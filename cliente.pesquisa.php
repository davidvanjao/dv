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
        <link rel="stylesheet" href="assets/css/pesquisa.css">
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
                                <a href="sair.php">Fazer Logoff</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-cesta">
                                    <div class="campo-inserir">

                                        <form class="busca-area" name="buscar-form" method="POST">
                                            <input class="input-busca-produto" type="text" autocomplete="off" name="cliente" placeholder="Digite o cliente">
                                            <input class="input-botao" type="submit" name="botao-pesquisar" value="Pesquisar">
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
                                                <th style="width:10%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php

                                                    if(isset($_POST['cliente']) && empty($_POST['cliente']) == false) { //se existir/ e ele nao estiver vazio.

                                                        $cliente = addslashes($_POST['cliente']);

                                                        $sql = "SELECT a.id, a.nome, a.telefone, b.cidadeEstado, b.bairro, b.logradouro, a.numero 
                                                        from tb_cliente as a join tb_endereco as b
                                                        on a.idEndereco = b.id 
                                                        WHERE a.nome LIKE '%".$cliente."%' 
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
                                                                echo '<td style="width:10%;"><a href="delivery.painel2.php?id='.$cliente['id'].'">adicionar</a>'; 
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