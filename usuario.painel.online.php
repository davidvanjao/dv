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

if($usuarios->temPermissao('CON') == false) {
    header("Location:index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Cadastro de Usuários</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/usuario.css">
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
                                <a href="usuario.painel.1.php">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">                                   

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:2%;">Id</th>
                                                <th style="width:10%;">Nome</th>
                                                <th style="width:10%;">Usuário</th>
                                                <th style="width:10%;">Data Acesso</th>
                                                <th style="width:3%;">Status</th>
                                                <th style="width:3%;">Ações</th>
                                                
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php


                                                $sql = "SELECT b.id, b.nome, b.usuario, DATE_FORMAT(a.data_login,'%d/%m/%Y %h:%m') as data_login, a.status
                                                FROM 
                                                tb_log_sessao a,
                                                tb_usuarios b
                                                WHERE 
                                                a.usuario = b.id
                                                and a.status = 'S'
                                                ORDER BY b.nome";

                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $usuario) {

                                                        echo "<tr>";
                                                        echo "<td style='width:2%;'>".$usuario['id']."</td>";
                                                        echo "<td style='width:10%;'>".$usuario['nome']."</td>";
                                                        echo "<td style='width:10%;'>".$usuario['usuario']."</td>";
                                                        echo "<td style='width:10%;'>".$usuario['data_login']."</td>";
                                                        if($usuario['status'] == 'S') {
                                                            echo "<td style='width:3%; background-color: #008000; text-align:center; color:#fff;'><strong>ONLINE</strong></td>";
                                                        }                               
                                                        echo '<td style="width:3%;"><a style="background-color: #ff0000;" href="usuario.processo.php?liberar='.$usuario['id'].'">Logoff</a>';
                                                        echo "</tr>";  
                                                    }
                                                } else {
                                                        
                                                        echo "Nenhum usuario online.";
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