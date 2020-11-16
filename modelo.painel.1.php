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

if(isset($_SESSION['logado'])) {

    $sql = "SELECT MAX(orcamento) FROM tb_orcamento";
    $sql = $pdo->query($sql);
    
    if($sql->rowCount() > 0) {
    
        $orcamento = $sql->fetch();
        $orcamento = $orcamento[0] + 1;   
    
    } else {
    
        $orcamento = 1;
    }


}

var_dump($_SESSION);

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Pesquisa</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/pesquisa.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">
        

                            
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
                                <a href="configuracao.painel.php">Voltar</a>
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-busca">
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar-form" method="POST" action="modelo.processo.php">
                                            <input type="hidden" name="orcamentoPainel" value="<?php echo $orcamento ?>">
                                            <input type="hidden" name="usuario" value="<?php echo $_SESSION['logado']?>">
                                            <input class="input-botao" type="submit" name="botaoIniciarOrcamento" value="Adicionar">
                                        </form>
                                    </div>
                                    
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Código</th>
                                                <th style="width:50%;">Produto</th>
                                                <th style="width:10%;">Quantidade</th>
                                                <th style="width:10%;">Preço</th>
                                                <th style="width:10%;">Estoque</th>
                                                <th style="width:10%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php                                 

                                            $sql = "SELECT a.id, b.nome, c.cidadeEstado, c.logradouro, b.numero, a.statuss, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data
                                            from tb_log_delivery as a join tb_cliente as b join tb_endereco as c 
                                            on a.idCliente = b.id 
                                            and b.idEndereco = c.id
                                            where a.statuss = 'PEDIDO REALIZADO'
                                            order by a.id";

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
                                                        $cor="##ffa500";
                                                    }
                                                    if($delivery['statuss']=="SAIU PARA ENTREGA"){
                                                        $cor="#008000";
                                                    }  

                                                    echo "<tr>";
                                                    echo "<td style='width:5%;'>".$delivery['id']."</td>";
                                                    echo "<td style='width:10%;'>".$delivery['saida_data']."</td>";
                                                    echo "<td style='width:10%;'>".$delivery['nome']."</td>";
                                                    echo "<td style='width:10%;'>".$delivery['cidadeEstado']."</td>";
                                                    echo "<td style='width:10%;'>".$delivery['logradouro']."</td>";  
                                                    echo "<td style='width:10%;'>".$delivery['numero']."</td>";     
                                                    echo "<td style='width:10%; background-color:$cor;'>".$delivery['statuss']."</td>";                           
                                                    echo "</tr>";  

                                                
                                                }
                                            } else {                                                    
                                                echo "Nenhuma compra pendente.";
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