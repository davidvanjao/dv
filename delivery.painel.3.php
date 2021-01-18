<?php

session_start();
require 'conexao.banco.php';
//require 'conexao.banco.oracle.php';
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
                                                <th style="width:10%;">Ticket</th>
                                                <th style="width:10%;">Data</th>
                                                <th style="width:10%;">Nome</th>
                                                <th style="width:5%;">Açougue</th>
                                                <th style="width:5%;">Status</th>
                                                <th style="width:5%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="busca-resultado">
                                            <table>
                                                <?php

                                                $sql = "SELECT a.id, a.orcamento, a.idCliente, a.statuss, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data
                                                FROM 
                                                tb_log_delivery a
                                                WHERE 
                                                a.statuss IN ('PEDIDO REALIZADO', 'EM ANDAMENTO', 'LIBERADO PARA ENTREGA' )
                                                GROUP BY a.orcamento";
                                                                                                                                                

                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $delivery) {

                                                        $orcamento = $delivery['orcamento'];

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
                                                        echo "<td style='width:10%;'>".str_pad($delivery['orcamento'], 4, 0, STR_PAD_LEFT)."</td>";
                                                        echo "<td style='width:10%;'>".$delivery['saida_data']."</td>";

                                                        /*$consulta = "SELECT a.seqpessoa, a.nomerazao
                                                        FROM 
                                                        CONSINCO.GE_PESSOA a
                                                        WHERE
                                                        a.seqpessoa = '$codCliente'";

                                                        //prepara uma instrucao para execulsao
                                                        $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                                        //Executa os comandos SQL
                                                        oci_execute($resultado);

                                                        while (($cliente = oci_fetch_array($resultado, OCI_ASSOC)) != false) {

                                                            echo "<td style='width:10%;'>".$cliente['NOMERAZAO']."</td>";

                                                        }*/

                                                        $sql = "SELECT c_gondola, pedido
                                                        FROM 
                                                        tb_orcamento
                                                        WHERE 
                                                        orcamento = '$orcamento'";

                                                        $sql = $pdo->query($sql); 
                                                        if($sql->rowCount() > 0) {

                                                            $acougue = $sql->fetchAll();

                                                            if (in_array('96', $acougue)) {
                                                                echo "encontrado</br>";
                                                            } else {
                                                                echo "nao encontrado</br>";
                                                            }

                                                            /*foreach($sql->fetchAll() as $acougue) {

                                                                if (in_array('96', $acougue)) {
                                                                    echo "encontrado</br>";
                                                                } else {
                                                                    echo "nao encontrado</br>";
                                                                }



                                                            }*/

                                                            var_dump($acougue['c_gondola']);


                                                            /*echo "<td style='width:5%;'>";
                                                        
                                                                if($acougue['c_gondola'] == '96' && $acougue['pedido'] == 'N') {

                                                                    echo "AGUARDANDO";

                                                                }
                                                                if($acougue['c_gondola'] == '96' && $acougue['pedido'] == 'S') {

                                                                    echo "PRONTO";

                                                                }
                                                                if($acougue['c_gondola'] != '96' && $acougue['pedido'] == 'N') {

                                                                    echo "-";

                                                                }
                                                        
                                                            "</td>";*/

                                                            
                                                        }

                                                        echo "<td style='background-color:$cor; width:5%;'>".$delivery['statuss']."</td>";
                                                        echo '<td style="width:5%;">';
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