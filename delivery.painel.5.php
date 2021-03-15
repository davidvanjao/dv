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

$data = date('Y-m-d');

$sql = "SELECT a.id, a.orcamento, a.idCliente, a.statuss, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data, a.usuario, b.nome
        FROM 
        tb_log_delivery a,
        tb_usuarios b
        WHERE 
        a.statuss IN ('PEDIDO REALIZADO', 'EM ANDAMENTO', 'LIBERADO PARA ENTREGA', 'SAIU PARA ENTREGA' )
        AND a.dataa = '$data'
        and a.usuario = b.id
        GROUP BY a.orcamento";

if(isset($_GET['data']) && empty($_GET['data']) == false){

    $data = addslashes($_GET['data']);

    $sql = "SELECT a.id, a.orcamento, a.idCliente, a.statuss, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data, a.usuario, b.nome
        FROM 
        tb_log_delivery a,
        tb_usuarios b
        WHERE 
        a.statuss IN ('PEDIDO REALIZADO', 'EM ANDAMENTO', 'LIBERADO PARA ENTREGA', 'SAIU PARA ENTREGA' )
        AND a.dataa = '$data'
        and a.usuario = b.id
        GROUP BY a.orcamento";
}

$seq = "1";

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Delivery Entrega</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/delivery.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="refresh" content="30">
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
                                <!--<a href="delivery.painel.3.php">Controle</a>-->
                                <a href="delivery.painel.5.php">Status</a>
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar" method="GET">
                                            <input class="input-busca-delivery"type="date" value="<?php echo $data;?>" name="data" autocomplete="off" required="required" onchange="this.form.submit()"/>
                                        </form>                                        
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:2%;">Nº</th>
                                                <th style='width:10%;'>TICKET</th>
                                                <th style='width:10%;'>DATA</th>
                                                <th style='width:10%;'>NOME</th>
                                                <th style='width:10%;'>ENDEREÇO</th>
                                                <th style="width:5%; text-align:center;">STATUS</th>
                                                <th style="width:5%; text-align:center;">ATENDENTE</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php      

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
                                                            echo "<td style='width:2%;'>".$seq++."</td>";
                                                            echo "<td style='width:10%;'><strong>".str_pad($delivery['orcamento'], 4, 0, STR_PAD_LEFT)."</strong></td>";
                                                            echo "<td style='width:10%;'>".$delivery['saida_data']."</td>";

                                                            $consulta = "SELECT a.seqpessoa, a.nomerazao, a.nomerazao, a.logradouro, a.nrologradouro
                                                            FROM 
                                                            CONSINCO.GE_PESSOA a
                                                            WHERE
                                                            a.seqpessoa = '$codCliente'";

                                                            //prepara uma instrucao para execulsao
                                                            $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                                            //Executa os comandos SQL
                                                            oci_execute($resultado);

                                                            while (($cliente = oci_fetch_array($resultado, OCI_ASSOC)) != false) {

                                                                echo "<td style='width:10%;'>".@$cliente['NOMERAZAO']."</td>";
                                                                echo "<td style='width:10%;'>".@$cliente['LOGRADOURO'].' '.@$cliente['NROLOGRADOURO']."</td>";  

                                                            }
                                                            
                                                            echo "<td style='background-color:$cor; width:5%; text-align:center;'>".$delivery['statuss']."</td>";   
                                                            echo "<td style='width:5%; text-align:center;'><strong>".$delivery['nome']."</strong></td>";                       
                                                            echo "</tr>";  

                                                        
                                                        }
                                                    } else {
                                            
                                                        echo "Nenhum lançamento encontrado!";
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