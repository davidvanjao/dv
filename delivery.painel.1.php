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
$data = date('Y-m-d');
$usuario = $_SESSION['logado'];

$sql = "SELECT a.id, a.orcamento, a.idCliente, nomeCliente, a.statuss, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data
    FROM 
    tb_log_delivery a
    WHERE 
    a.statuss IN ('PEDIDO REALIZADO', 'EM ANDAMENTO', 'LIBERADO PARA ENTREGA')
    AND a.usuario = '$usuario'
    AND a.dataa = '$data'
    ORDER BY a.id";

if(isset($_GET['data']) && empty($_GET['data']) == false){ 

    $data = addslashes($_GET['data']);

    $sql = "SELECT a.id, a.orcamento, a.idCliente, nomeCliente, a.statuss, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data
    FROM 
    tb_log_delivery a
    WHERE 
    a.statuss IN ('PEDIDO REALIZADO', 'EM ANDAMENTO', 'LIBERADO PARA ENTREGA')
    AND a.usuario = '$usuario'
    AND a.dataa = '$data'
    ORDER BY a.id";
}

//=================================================================================================================

//var_dump($_SESSION);

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
                                <!--<a href="delivery.painel.3.php">Controle</a>-->
                                <a href="delivery.painel.5.php">Status</a>
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir delivery1">
                                        <form class="busca-area" name="buscar-form" method="POST" action="delivery.processo.php">
                                            <input class="input-botao" type="submit" name="adicionaLista" value="Criar Lista">
                                        </form>
                                        <form class="busca-area" name="buscar" method="GET">
                                            <input class="input-busca-delivery"type="date" value="<?php echo $data;?>" name="data" autocomplete="off" required="required" onchange="this.form.submit()"/>
                                        </form>   
                                    </div>
                                    
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:5%;">TICKET</th>
                                                <th style="width:5%;">DATA</th>
                                                <th style="width:10%;">NOME</th>
                                                <th style="width:5%;">STATUS</th>
                                                <th style="width:4%;">AÇÕES</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php  

                                            $sql = $pdo->query($sql);   
                                            if($sql->rowCount() > 0) {
                                                foreach($sql->fetchAll() as $delivery) {
                                                    
                                                    echo "<tr>";
                                                    echo "<td style='width:5%;'><strong>".str_pad($delivery['orcamento'], 4, 0, STR_PAD_LEFT)."</strong></td>";
                                                    echo "<td style='width:5%;'>".$delivery['saida_data']."</td>";
                                                    echo "<td style='width:10%;'>".$delivery['nomeCliente']."</td>";
                                                    echo "<td style='width:5%;'>".$delivery['statuss']."</td>"; 
                                                    echo '<td style="width:2%; background-color:#ff0000;"><a href="delivery.impressao.php?orcamento='.$delivery['orcamento'].'&cliente='.$delivery['idCliente'].'" target="_blank">Imprimir</a></td>';   

                                                    if($delivery['statuss'] == "PEDIDO REALIZADO") {

                                                        echo '<td style="width:2%; background-color:#008000;"><a href="delivery.editar.php?orcamento='.$delivery['orcamento'].'">Editar</a></td>'; 
                                                    } else {

                                                        echo '<td style="width:2%;"></a></td>'; 

                                                    }

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