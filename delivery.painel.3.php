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

    $sql = "SELECT a.id, a.orcamento, a.idCliente, a.nomeCliente, a.statuss, a.dataa, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data, a.usuario, b.nome
            FROM 
            tb_log_delivery a,
            tb_usuarios b
            WHERE 
            a.statuss IN ('PEDIDO REALIZADO', 'EM ANDAMENTO', 'LIBERADO PARA ENTREGA' )
            AND a.dataa = '$data'
            AND a.tipo = 'L'
            AND a.usuario = b.id
            GROUP BY a.orcamento";

if(isset($_GET['data']) && empty($_GET['data']) == false){

    $data = addslashes($_GET['data']);

    $sql = "SELECT a.id, a.orcamento, a.idCliente, a.nomeCliente, a.statuss, a.dataa, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data, a.usuario, b.nome
        FROM 
        tb_log_delivery a,
        tb_usuarios b
        WHERE 
        a.statuss IN ('PEDIDO REALIZADO', 'EM ANDAMENTO', 'LIBERADO PARA ENTREGA' )
        AND a.dataa = '$data'
        AND a.tipo = 'L'
        AND a.usuario = b.id
        GROUP BY a.orcamento";

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
                                <a href="delivery.painel.3.php">Controle</a> 
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
                                                <th style="width:3%;">TICKET</th>
                                                <th style="width:5%;">DATA</th>
                                                <th style="width:10%;">NOME</th>
                                                <th style="width:5%;">AÇOUGUE</th>
                                                <th style="width:5%;">STATUS</th>
                                                <th style="width:5%;">OPERADOR</th>
                                                <th style="width:3%;">AÇÕES</th>
                                                <th style="width:3%;"></th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="busca-resultado">
                                            <table>
                                                <?php

                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $delivery) {

                                                        $orcamento = $delivery['orcamento'];   
                                                        
                                                        echo "<tr>";                                                        
                                                        echo "<td style='width:3%;'><strong>".str_pad($delivery['orcamento'], 4, 0, STR_PAD_LEFT)."</strong></td>";
                                                        echo "<td style='width:5%;'>".$delivery['saida_data']."</td>";
                                                        echo "<td style='width:10%;'>".$delivery['nomeCliente']."</td>";
                                                        

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

                                                        echo "<td style='width:5%;'>".$delivery['statuss']."</td>";
                                                        echo "<td style='width:5%;'><strong>".$delivery['nome']."</strong></td>";   
                                                        echo '<td style="width:3%; background-color:#ff0000;">';
                                                            echo '<div class="teste">';                                                            

                                                                if($delivery['statuss'] == 'PEDIDO REALIZADO') {
                
                                                                    echo '<a class="iniciar" onclick="return funcao1()" href="delivery.log.php?orcamento='.$orcamento.'">Iniciar</a>';

                                                                }
                                                                
                                                                if($delivery['statuss'] == 'EM ANDAMENTO') {

                                                                    echo '<a class="liberar" onclick="return funcao1()" href="delivery.log.php?orcamento='.$orcamento.'">Liberar</a>';

                                                                }
                                                                
                                                                if($delivery['statuss'] == 'LIBERADO PARA ENTREGA') {

                                                                    echo '<a class="entregar" onclick="return funcao1()" href="delivery.log.php?orcamento='.$orcamento.'">Entregar</a>';

                                                                }
                                                            echo '</div>';                                                             
                                                        echo '</td>'; 

                                                        echo "<td style='width:3%;'><a class='liberar' href='delivery.log.php?orcamento=".$orcamento."'>HORARIO</a></td>";
                                                                                                                                         
                                                        echo "</tr>";                                                      
                                                                     
                                                    }

                                                } else {
                                                        
                                                    echo "NENHUMA LISTA DE COMPRA PENDENTE";
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

        <script>
            function funcao1() {

                var confirmar = confirm("Você realmente deseja liberar?");

                if(confirmar == true) {

                    return true;

                } else {

                    return false;
                }
            }

        </script>
      
    </body>


</html>