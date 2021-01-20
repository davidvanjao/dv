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

                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar" method="GET">
                                            <input class="input-busca-delivery"type="button" value="" name="data"/>
                                        </form>                                        
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>                                                
                                                <th style="width:10%;">TICKET</th>
                                                <th style="width:10%;">DATA</th>
                                                <th style="width:10%;">NOME</th>
                                                <th style="width:5%;">AÇOUGUE</th>
                                                <th style="width:5%; text-align:center;">STATUS</th>
                                                <th style="width:5%; text-align:center;">ATENDENTE</th>
                                                <th style="width:5%; text-align:center;">AÇÕES</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="busca-resultado">
                                            <table>
                                                <?php

                                                $sql = "SELECT a.id, a.orcamento, a.idCliente, a.statuss, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data, a.usuario, b.nome
                                                FROM 
                                                tb_log_delivery a,
                                                tb_usuarios b
                                                WHERE 
                                                a.statuss IN ('PEDIDO REALIZADO', 'EM ANDAMENTO', 'LIBERADO PARA ENTREGA' )
                                                and a.usuario = b.id
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
                                                        echo "<td style='width:10%;'><strong>".str_pad($delivery['orcamento'], 4, 0, STR_PAD_LEFT)."</strong></td>";
                                                        echo "<td style='width:10%;'>".$delivery['saida_data']."</td>";
                                                        

                                                        $consulta = "SELECT a.seqpessoa, a.nomerazao
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

                                                        }

                                                        $sql = "SELECT c_gondola, pedido
                                                        FROM 
                                                        tb_orcamento
                                                        WHERE 
                                                        orcamento = '$orcamento'
                                                        and c_gondola = '96'
                                                        group by c_gondola";

                                                        $sql = $pdo->query($sql); 
                                                        if($sql->rowCount() > 0) {

                                                            foreach($sql->fetchAll() as $acougue) {

                                                                if (in_array('96', $acougue)) {

                                                                    echo "<td style='width:5%;'>";
                                                        
                                                                        if($acougue['c_gondola'] == '96' && $acougue['pedido'] == 'N') {

                                                                            echo "AGUARDANDO";

                                                                        } elseif($acougue['c_gondola'] == '96' && $acougue['pedido'] == 'S') {

                                                                            echo "PRONTO";

                                                                        }
                                                        
                                                                    "</td>";

                                                                }
                                                            }
                                                           
                                                        } else {

                                                            echo "<td style='width:5%;'>-</td>";
                                                        }

                                                        echo "<td style='background-color:$cor; width:5%; text-align:center;'>".$delivery['statuss']."</td>";
                                                        echo "<td style='width:5%; text-align:center;'><strong>".$delivery['nome']."</strong></td>";   
                                                        echo '<td style="width:5%;">';
                                                            echo '<div class="teste">';
                                                            

                                                                        if($delivery['statuss'] == 'PEDIDO REALIZADO') {

                                                                            echo '<a class="iniciar" href="delivery.processo.php?andamento='.$delivery['id'].'">Iniciar</a>';

                                                                        }
                                                                        
                                                                        if($delivery['statuss'] == 'EM ANDAMENTO') {

                                                                        //echo '<a class="liberar" href="delivery.painel.4.php?id='.$delivery['id'].'">Liberar</a>';
                                                                        echo '<a class="liberar" href="delivery.processo.php?liberado='.$delivery['id'].'">Liberar</a>';

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