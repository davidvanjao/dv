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

$data = date('Y-m-d');

$sql = "SELECT a.id, a.orcamento, a.dataa, b.nome, c.cidadeEstado, c.logradouro, b.numero, a.statuss, c.regiao, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data
            from tb_log_delivery a, tb_cliente b, tb_endereco c
            WHERE a.dataa LIKE '$data'
            and a.idCliente = b.id 
            and b.idEndereco = c.id
            order by a.statuss";


if(isset($_GET['data']) && empty($_GET['data']) == false){

    $data = addslashes($_GET['data']);

    $sql = "SELECT a.id, a.orcamento, a.dataa, b.nome, c.cidadeEstado, c.logradouro, b.numero, a.statuss, c.regiao, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data
            from tb_log_delivery a, tb_cliente b, tb_endereco c
            WHERE a.dataa LIKE '$data'
            and a.idCliente = b.id 
            and b.idEndereco = c.id
            order by a.statuss";
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Delivery Entrega</title>
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
                                            <input class="input-busca-delivery"type="date" value="<?php echo $data;?>" name="data" autocomplete="off" required="required" onchange="this.form.submit()"/>
                                        </form>                                        
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th>Ticket</th>
                                                <th>Data</th>
                                                <th>Nome</th>
                                                <th>Endereço</th>
                                                <th>Status</th>
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
                                                            echo "<td>".str_pad($delivery['orcamento'], 4, 0, STR_PAD_LEFT)."</td>";
                                                            echo "<td>".$delivery['saida_data']."</td>";
                                                            echo "<td>".$delivery['nome']."</td>";
                                                            echo "<td>".$delivery['logradouro'].' '.$delivery['numero']."</td>";  
                                                            
                                                            echo "<td background-color:$cor;'>".$delivery['statuss']."</td>";                        
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