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
        <title>Cadastro de Cliente</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/cadastroCliente.css">
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

                                        <form method="POST" action="cadastro.cliente.endereco.php">
                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar">
                                        </form>
                                        
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:20%;">Nome</th>
                                                <th style="width:10%;">Telefone</th>
                                                <th style="width:10%;">Cidade</th>
                                                <th style="width:20%;">Endereço</th>
                                                <th style="width:3%;">Nº</th>
                                                <th style="width:5%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php

                                                $sql = "SELECT a.id, a.nome, a.telefone, b.cidadeEstado, b.bairro, b.logradouro, a.numero 
                                                from tb_cliente as a join tb_endereco as b 
                                                on a.idEndereco = b.id 
                                                order by a.nome";

                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $cliente) {

                                                        echo "<tr>";
                                                        echo "<td style='width:20%;'>".$cliente['nome']."</td>";
                                                        echo "<td style='width:10%;'>".$cliente['telefone']."</td>";
                                                        echo "<td style='width:10%;'>".$cliente['cidadeEstado']."</td>";
                                                        echo "<td style='width:20%;'>".$cliente['logradouro']."</td>";  
                                                        echo "<td style='width:3%;'>".$cliente['numero']."</td>";    
                                                        echo '<td style="width:5%;"><a href="cadastro.cliente.editar.php?idCliente='.$cliente['id'].'">Editar</a>';                           
                                                        echo "</tr>";  

                                                    
                                                    }
                                                } else {
                                                        
                                                        echo "Nenhum cliente encontrado.";
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