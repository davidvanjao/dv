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
        <title>Delivery Logistica</title>
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
                                <a href="delivery.painel.1.php">Lista</a>                              
                                <a href="delivery.painel.3.php">Controle</a> 
                                <a href="delivery.painel.5.php">Status</a>
                                <a href="index.php">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:5%;">Ticket</th>
                                                <th style="width:10%;">Data</th>
                                                <th style="width:20%;">Nome</th>
                                                <th style="width:10%;">Cidade</th>
                                                <th style="width:20%;">Endereço</th>
                                                <th style="width:10%;">Açougue</th>
                                                <th style="width:20%;">Status</th>
                                                <th style="width:20%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="busca-resultado">
                                            <table>
                                                <?php

                                                $sql = "SELECT a.id, a.orcamento, b.nome, c.cidadeEstado, c.logradouro, b.numero, d.pedido, d.c_gondola, a.statuss, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data
                                                from tb_log_delivery a, tb_cliente b, tb_endereco c, tb_orcamento d
                                                where a.idCliente = b.id 
                                                and a.orcamento = d.orcamento 
                                                and b.idEndereco = c.id
                                                and a.statuss IN ('PEDIDO REALIZADO', 'EM ANDAMENTO', 'LIBERADO PARA ENTREGA' )
                                                group by a.orcamento";
                                                                                                

                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $delivery) {

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
                                                        
                                                        if($delivery['c_gondola'] == '96' && $delivery['pedido'] == 'N'){
                                                            $cor2="";
                                                        }
                                                        if($delivery['c_gondola'] == '96' && $delivery['pedido'] == 'S'){
                                                            $cor2="#008000";
                                                        }

                                                        echo "<tr>";
                                                        echo "<td style='width:5%;'>".$delivery['orcamento']."</td>";
                                                        echo "<td style='width:10%;'>".$delivery['saida_data']."</td>";
                                                        echo "<td style='width:20%;'>".$delivery['nome']."</td>";
                                                        echo "<td style='width:10%;'>".$delivery['cidadeEstado']."</td>";
                                                        echo "<td style='width:20%;'>".$delivery['logradouro']."</td>";  

                                                        echo "<td style='width:10%; background-color:;'>";
                                                        
                                                            if($delivery['c_gondola'] == '96' && $delivery['pedido'] == 'N') {

                                                                echo "AGUARDANDO";

                                                            }
                                                            if($delivery['c_gondola'] == '96' && $delivery['pedido'] == 'S') {

                                                                echo "PRONTO";

                                                            }
                                                            if($delivery['c_gondola'] != '96' && $delivery['pedido'] == 'N') {

                                                                echo "-";

                                                            }
                                                        
                                                        "</td>";

                                                        
                                                        
                                                        
                                                        echo "<td style='width:20%; background-color:$cor;'>".$delivery['statuss']."</td>";
                                                        echo '<td style="width:20%;">';
                                                        echo '<div class="teste">';
                                                        

                                                                    if($delivery['statuss'] == 'PEDIDO REALIZADO') {

                                                                        echo '<a class="iniciar" href="delivery.processo.php?andamento='.$delivery['id'].'">Iniciar</a>';

                                                                    }
                                                                    
                                                                    if($delivery['statuss'] == 'EM ANDAMENTO') {

                                                                       echo '<a class="liberar" href="delivery.painel.4.php?id='.$delivery['id'].'">Liberar</a>';

                                                                    }
                                                                    
                                                                    if($delivery['statuss'] == 'LIBERADO PARA ENTREGA') {

                                                                        echo '<a class="entregar" href="delivery.processo.php?saiu='.$delivery['id'].'">Entregar</a>';
 
                                                                    }
                                                        echo '</div>';                                                             
                                                        echo '</td>';                           
                                                        echo "</tr>";                                                      
                                                                     
                                                    }

                                                } else {
                                                        
                                                    echo "Nenhum lista de compra pendente.";
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