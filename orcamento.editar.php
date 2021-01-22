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

if($usuarios->temPermissao('ORC') == false) {
    header("Location:index.php");
    exit;
}

//var_dump($_SESSION);

//=========================================VARIAVEIS========================================================================

$codigoCliente = "";
$nomeCliente = "";
$valorTotal = "00.00";


//VARIAVEIS DA SESSAO REFERENTE A SOMA TOTAL
$precoSessao = "";
$quantidadeSessao = "";    
$soma2 = "";


//PUXA DADOS DO CABECALHO
if(isset($_GET['orcamento']) && !empty($_GET['orcamento'])) {

    $orcamento = addslashes($_GET['orcamento']);

    $sql = "SELECT a.orcamento, a.pagamento, a.nomeCliente, b.quantidade, b.valor_total
    FROM 
    tb_log_delivery a,
    tb_orcamento b
    WHERE 
    a.orcamento = '$orcamento'
    and tipo = 'O'
    and a.orcamento = b.orcamento
    ORDER BY a.id";

    $sql = $pdo->query($sql);   
    if($sql->rowCount() > 0) {

        foreach($sql->fetchAll() as $key=>$dados) {

            $formaPagamento = $dados['pagamento'];
            $nomeCliente = $dados['nomeCliente'];

            $quantidade = $dados['quantidade'];
            $valor = $dados['valor_total'];

            $soma = $valor * $quantidade;

            $valorTotal += $soma;

        }
    }

    if(!empty($_SESSION['lista'])) {

        foreach($_SESSION['lista'] as $key=>$value) {

            $precoSessao = $value['preco'];
            $quantidadeSessao = $value['quantidade'];    
            
            $soma2 = $precoSessao * $quantidadeSessao;

            $valorTotal += $soma2; 

        }
    }


  
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Orçamento</title>
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
                                <a href="orcamento.processo.editar.php?sairEditar">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">

                                        <div class="formulario-cliente">   

                                            <div class="form-cliente-caixa">
                                                <form class="form-cliente" name="buscar-form">
                                                    <div>
                                                        <label>Nome:</label></br>
                                                        <input class="input-nome" type="text" autocomplete="off" name="nome" value="<?php echo $nomeCliente ?>" readonly="readonly"/>    
                                                    </div>                                                     
                                                </form>
                                            </div>

                                            <div class="form-cliente-caixa">
                                                <form class="form-pagamento">
                                                    <div>
                                                        <label>F. Pagamento</label></br>
                                                        <input class="input-nome" type="text" autocomplete="off" name="nome" value="<?php echo $formaPagamento ?>" readonly="readonly"/>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            <div class="form-cliente-caixa">
                                                <div>
                                                    <label>N. Orç.</label></br>
                                                    <input class="input-orc" type="text" name="pesquisa" value="<?php echo $orcamento?>" readonly="readonly">
                                                </div>
                                                <div class="valor-total">
                                                    <label>V. Total</label></br>
                                                    <input class="input-total" type="text" name="pesquisa" value='<?php echo "R$ ".number_format($valorTotal,2,",",".")?>' readonly="readonly">
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="formulario-controle">
                                            <div class="bottoens">
                                                <form class="busca-area" name="buscar-form" method="GET" action="orcamento.produto.pesquisa.php">
                                                    <input type="hidden" name="orcamento" value="<?php echo $orcamento ?>">
                                                    <input type="submit" name="adicionarEditar" value="Incluir Produto">
                                                </form>   

                                                <form class="busca-area" name="buscar-form" method="GET" action="orcamento.processo.editar.php">
                                                    <input type="hidden" name="orcamento" value="<?php echo $orcamento ?>">
                                                    <input type="submit" name="atualizar" value="Atualizar">
                                                </form>
                                            </div>
                                        </div>

                                            
                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr class="cabecalho" style="border:1px solid #000;">
                                                <th style="width:10%;">CÓDIGO</th>
                                                <th style="width:20%;">PRODUTO</th>
                                                <th style="width:5%;">EMB</th>
                                                <th style="width:5%;">QTD</th>
                                                <th style="width:5%;">PREÇO</th>
                                                <th style="width:5%;">TOTAL</th>                                                
                                                <th style="width:5%;">AÇÕES</th>                                                    
                                            </tr>                                                                                       
                                        </table> 
                                    </div>
                                    <div class="corpo-lista">        

                                        <div class="busca-resultado largura"> 
                                            <table>   

                                                <?php

                                                if(isset($_GET['orcamento']) && !empty($_GET['orcamento'])) {

                                                    $sql = "SELECT id, orcamento, ean, produto, c_produto, medida, quantidade, valor_total
                                                    FROM 
                                                    tb_orcamento
                                                    WHERE 
                                                    orcamento = '$orcamento'
                                                    ORDER BY produto";

                                                    $sql = $pdo->query($sql); 
                                                      
                                                    if($sql->rowCount() > 0) {

                                                        foreach($sql->fetchAll() as $key=>$value) {

                                                            $preco = $value['valor_total'];
                                                            $quantidade = $value['quantidade'];
                                                            $medida = $value['medida'];
                                                            $resultado = number_format($preco*$quantidade,2,",",".");                                            

                                                            echo "<tr>";
                                                            echo "<td style='width:10%;'>".$value['ean']."</td>";
                                                            echo "<td style='width:20%;'>".$value['produto']."</td>";
                                                            echo "<td style='width:5%;'>".$medida."</td>";
                                                            echo "<td style='width:5%;'>".$quantidade."</td>";                                                     
                                                            echo "<td style='width:5%;'>R$".number_format($preco,2,",",".")."</td>";
                                                            echo "<td style='width:5%;'>R$".$resultado."</td>";
                                                            echo '<td style="width:5%;"><a href="orcamento.processo.editar.php?excluirItem='.$value['c_produto'].'&orcamento='.$orcamento.'">Excluir</a>';
                                                            echo "</tr>";  
                                                        } 
                                                    }
                                                }   
                                                
                                                if(!empty($_SESSION['lista'])) {

                                                    foreach($_SESSION['lista'] as $key=>$value) {

                                                        $preco = $value['preco'];
                                                        $quantidade = $value['quantidade'];
                                                        $observacao = $value['observacao'];
                                                        $medida = $value['medida'];
                                                        $resultado = number_format($preco*$quantidade,2,",",".");                                            

                                                        echo "<tr>";
                                                        echo "<td style='width:10%;'>".$value['codigoEan']."</td>";
                                                        echo "<td style='width:20%;'>".$value['produto']."</td>";
                                                        echo "<td style='width:5%;'>".$medida."</td>";
                                                        echo "<td>
                                                                <form class='' name='teste' method='GET' action='orcamento.processo.editar.php'>   

                                                                    <input value=".$orcamento." class='quantidade' type='hidden' name='orcamento' required='required'>   
                                                                    <input value=".$value['codigo']." class='quantidade' type='hidden' name='codigoProduto' required='required'>
                                                                    <input value=".$quantidade." class='quantidade' type='number' min='0' name='quantidade' required='required' onchange='this.form.submit()'>                                                        

                                                                </form>     
                                                               </td>"; 

                                                        echo "<td style='width:5%;'>R$".number_format($preco,2,",",".")."</td>";
                                                        echo "<td style='width:5%;'>R$".$resultado."</td>";
                                                        echo '<td style="width:5%;"><a href="orcamento.processo.editar.php?excluirItemSessao='.$value['codigo'].'&orcamento='.$orcamento.'">Excluir</a>';
                                                        echo "</tr>";  
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