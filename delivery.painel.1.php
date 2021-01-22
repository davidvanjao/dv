<?php

session_start();
require 'conexao.banco.php';
require 'conexao.banco.oracle.php';
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

$usuario = $_SESSION['logado'];

//=================================================================================================================

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Pesquisa</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/delivery.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">

                        <?php require 'menuLateral.php'; ?>
                        
                            
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
                                <a href="delivery.painel.1.php">Lista</a>                              
                                <a href="delivery.painel.3.php">Controle</a> 
                                <a href="delivery.painel.5.php">Status</a>
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar-form" method="POST" action="delivery.processo.php">
                                            <input class="input-botao" type="submit" name="adicionaLista" value="Criar Lista">
                                        </form>
                                    </div>
                                    
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">TICKET</th>
                                                <th style="width:10%;">DATA</th>
                                                <th style="width:10%;">NOME</th>
                                                <th style="width:5%;">STATUS</th>
                                                <th style="width:10%;">AÇÕES</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php                                 

                                            $sql = "SELECT a.id, a.orcamento, a.idCliente, nomeCliente, a.statuss, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data
                                            FROM 
                                            tb_log_delivery a
                                            WHERE 
                                            a.statuss IN ('PEDIDO REALIZADO', 'EM ANDAMENTO', 'LIBERADO PARA ENTREGA')
                                            and a.usuario = '$usuario'
                                            ORDER BY a.id";

                                            $sql = $pdo->query($sql);   
                                            if($sql->rowCount() > 0) {
                                                foreach($sql->fetchAll() as $delivery) {

                                                    $codCliente = $delivery['idCliente'];

                                                    if($delivery['statuss']=="PEDIDO REALIZADO"){
                                                        $cor="";
                                                    }
                                                    if($delivery['statuss']=="EM ANDAMENTO"){
                                                        $cor="#ff0000";
                                                    }
                                                    if($delivery['statuss']=="LIBERADO PARA ENTREGA"){
                                                        $cor="#ffa500";
                                                    }
                                                    if($delivery['statuss']=="SAIU PARA ENTREGA"){
                                                        $cor="#008000";
                                                    }  

                                                    echo "<tr>";
                                                    echo "<td style='width:10%;'><strong>".str_pad($delivery['orcamento'], 4, 0, STR_PAD_LEFT)."</strong></td>";
                                                    echo "<td style='width:10%;'>".$delivery['saida_data']."</td>";
                                                    echo "<td style='width:10%;'>".$delivery['nomeCliente']."</td>";
                                                    echo "<td style='background-color:$cor; width:5%;'>".$delivery['statuss']."</td>"; 
                                                    echo '<td style="width:5%;"><a href="delivery.impressao.php?orcamento='.$delivery['orcamento'].'&cliente='.$delivery['idCliente'].'" target="_blank">Imprimir</a></td>';   
                                                    echo '<td style="width:5%;"><a href="delivery.editar.php?orcamento='.$delivery['orcamento'].'">Editar</a></td>';           
                                                    echo "</tr>";  

                                                
                                                }
                                            } else {   

                                                echo "NENHUMA COMPRA PENDENTE!";

                                            }

                                                
                                            ?>                                        
                                        </table>
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