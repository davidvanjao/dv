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

//=========================================VARIAVEIS========================================================================

$codigoCliente = "";
$nomeCliente = "";
$valorTotal = "00.00";
$formaPagamento = "";

//=========================================SE REFERE AO ORCAMENTO========================================================================

if(isset($_GET['orcamento'])) {
    $orcamento = $_GET['orcamento'];
}

//=========================================SE REFERE AO CLIENTE========================================================================

if(isset($_GET['orcamento'])) {
    
    $sql = "SELECT a.id, a.nome, a.idEndereco, b.logradouro, a.numero, b.cidadeEstado, a.telefone, b.cidadeEstado, c.orcamento, c.pagamento, d.usuario, DATE_FORMAT(c.dataPedido,'%d/%m/%Y %H:%i') as saida_data
    from tb_cliente a, tb_endereco b, tb_log_delivery c, tb_usuarios d
    where c.orcamento = '$orcamento'
    and c.idCliente = a.id
    and c.usuario = d.id
    and c.idEndereco = b.id";

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {        

        foreach($sql->fetchAll() as $delivery) { 
            $idNome = $delivery['id'];
            $nome = $delivery['nome'];
            $orcamento = $delivery['orcamento'];
            $dataPedido = $delivery['saida_data'];  
            $usuario  = explode(".", $delivery['usuario']);
            $pagamento = $delivery['pagamento']; 

        }   
                
    }
}
$total = "";
$valorTotal = floatval("00,00");



?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Edição de pedido</title>
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
                                <a href="delivery.painel.1.php">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">

                                        <div class="formulario-cliente">    
                                            <div class="form-cliente-caixa">
                                                <form class="form-cliente" name="buscar-form" method="POST">
                                                    <div>
                                                        <input class="input5" type="hidden" min='0' autocomplete="off" name="numero" value="<?php echo $idNome ?>" readonly="readonly"/>
                                                    </div> 
                                                    <div>
                                                        <label>Nome:</label></br>
                                                        <input class="input-nome" type="text" autocomplete="off" name="nome" placeholder="" value="<?php echo $nome ?>" readonly="readonly"/>    
                                                    </div> 
                                                </form>
                                            </div>

                                            <div class="form-cliente-caixa">
                                                <form class="form-pagamento" action='delivery.processo.php' method='POST'>
                                                    <div>
                                                        <label>F. Pagamento</label></br>
                                                        <select class="input-pagamento" name="formaPagamento" onchange="this.form.submit()">
                                                            <option value=""><?php echo $pagamento?></option> 
                                                            <option value="Dinheiro">Dinheiro</option> 
                                                            <option value="Cartão">Cartão</option>
                                                            <option value="Cheque">Cheque</option>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            <div class="form-cliente-caixa">
                                                <div>
                                                    <label>N. Orç.</label></br>
                                                    <input class="input-orc" minlength="3" type="text" autocomplete="off" name="pesquisa" value="<?php echo $orcamento?>" readonly="readonly">
                                                </div>
                                                <div class="valor-total">
                                                    <label>V. Total</label></br>
                                                    <input class="input-total" minlength="3" type="text" autocomplete="off" name="pesquisa" value='<?php echo "R$ ".number_format($valorTotal,2,",",".")?>' readonly="readonly">
                                                </div>
                                            </div>

                                            
                                        </div>

                                        <hr>

                                        <div class="formulario-controle">     

                                            <div class="bottoens">
                                                <form class="busca-area" name="buscar-form" method="POST" action="delivery.produto.pesquisa.php">
                                                    <input type="submit" name="adicionarProduto" value="Incluir Produto">
                                                </form>   

                                                <form class="busca-area" name="buscar-form" method="POST" action="delivery.processo.php">

                                                    <input type="submit" name="salvarLista" value="Salvar Lista">

                                                </form>

                                            </div>

                                        </div>

                                            
                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                                                                       
                                        </table> 
                                    </div>
                                    <div class="corpo-lista">        

                                        <div class="busca-resultado largura"> 
                                            <table>   
                                                <tr>
                                                    <th style="width:5%;">Código</th>
                                                    <th style="width:40%;">Produto</th>
                                                    <th style="width:5%;">Med</th>
                                                    <th style="width:5%;">Qtd</th>
                                                    <th style="width:5%;">Preco</th>
                                                    <th style="width:5%;">Total</th>                                                
                                                    <th style="width:5%;">Est</th>
                                                    <th style="width:5%;">Obs</th>
                                                    <th style="width:10%;" >Ações</th>
                                                </tr> 
                                                <?php

                                                    if(!empty($orcamento)) {
                                                        
                                                        $sql = "SELECT d.c_produto, e.d_produto, d.quantidade, d.medida, e.preco, e.estoque, d.observacao
                                                        from tb_log_delivery c, tb_orcamento d, tb_produto e
                                                        where c.orcamento = '$orcamento'
                                                        and c.orcamento = d.orcamento
                                                        and d.c_produto = e.c_produto";

                                                        $sql = $pdo->query($sql);

                                                        if($sql->rowCount() > 0) {   

                                                            foreach($sql->fetchAll() as $key=>$value) {

                                                                $preco = $value['preco'];
                                                                $quantidade = $value['quantidade'];
                                                                $observacao = $value['observacao'];
                                                                $medida = $value['medida'];
                                                                $resultado = number_format($preco*$quantidade,2,",",".");

                                                                echo "<tr>";
                                                                echo "<td>".$value['c_produto']."</td>";
                                                                echo "<td>".$value['d_produto']."</td>";
                                                                echo "<td>
                                                                            <form class='form-pagamento' action='delivery.processo.php' method='GET'>
                                                                                <div>
                                                                                    <input value=".$value['c_produto']." class='quantidade' type='hidden' min='0'  name='produto' required='required'>
                                                                                    <select class='input-pagamento' name='medida' onchange='this.form.submit()'>
                                                                                        <option value=''>".$medida."</option> 
                                                                                        <option value='Kg'>Kg</option> 
                                                                                        <option value='Un'>Un</option>
                                                                                    </select>
                                                                                </div>
                                                                            </form>    
                                                                      </td>"; 

                                                                echo "<td>
                                                                        <form class='' name='teste' method='GET' action='delivery.processo.php'>      

                                                                            <input value=".$value['c_produto']." class='quantidade' type='hidden' min='0'  name='produto' required='required'>
                                                                            <input value=".$quantidade." class='quantidade' type='number' min='0'  name='quantidade' required='required' onchange='this.form.submit()'>                                                        

                                                                        </form>     
                                                                    </td>";  
                                                                                                                         
                                                                echo "<td>R$".number_format($preco,2,",",".")."</td>";
                                                                echo "<td>R$".$resultado."</td>";
                                                                echo "<td>".$value['estoque']."</td>"; 

                                                                echo "<td>
                                                                            <form class='' name='teste' method='GET' action='delivery.processo.php'>      

                                                                                <input value=".$value['c_produto']." class='observacao' type='hidden' min='0'  name='produto' required='required'>
                                                                                <input value=".$observacao." class='observacao' type='text' min='0'  name='observacao' onchange='this.form.submit()'>                                                        

                                                                            </form>     
                                                                    </td>";

                                                                echo '<td><a href="delivery.processo.php?Editarexcluir='.$value['c_produto'].'&orcamento='.$orcamento.'">Excluir</a>';
                                                                echo "</tr>";  
                                                            }
                                                        }
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