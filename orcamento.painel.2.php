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

if($usuarios->temPermissao('ORC') == false) {
    header("Location:index.php");
    exit;
}

//=========================================VARIAVEIS========================================================================

$codigoCliente = "";
$nomeCliente = "";
$valorTotal = "00.00";
$formaPagamento = "";
$bloco =".";
$checkbox = "";

//=========================================SE REFERE AO ORCAMENTO============================================================

if(isset($_SESSION['orcamento'])) {
    $orcamento = $_SESSION['orcamento'];
}

//=========================================SE REFERE AO CLIENTE==============================================================

if(isset($_SESSION['cliente'])) {
    $codigoCliente = $_SESSION['cliente']['id'];
    $nomeCliente = $_SESSION['cliente']['nome'];
}

//=========================================SE REFERE A FORMA DE PAGAMENTO======================================================

if(isset($_SESSION['formaPagamento'])) {
    $formaPagamento = $_SESSION['formaPagamento'];
}

//=========================================SE REFERE AO TOTAL DOS PRODUTOS======================================================

if(isset($_SESSION['lista'])) {

    foreach($_SESSION['lista'] as $key=>$value) {

        $soma = $value['preco'] * $value['quantidade'];

        $valorTotal += $soma;
    }

}

//===========================================SE REFERE AO BLOCO DE NOTAS======================================================================

if(isset($_SESSION['blocoNotas'])) {

    $checkbox = $_SESSION['blocoNotas']['checkbox'];
    $bloco = $_SESSION['blocoNotas']['bloco'];

}

//=================================================================================================================


//var_dump($_SESSION);
//echo $bloco;
//var_dump($valorGeral);


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
                                <a href="orcamento.processo.php?excluirLista">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">

                                        <div class="formulario-cliente">   

                                            <div class="form-cliente-caixa">
                                                <form class="form-cliente" name="buscar-form" method="POST" action="orcamento.cliente.pesquisa.php">
                                                    <div>
                                                        <input class="input5" type="hidden" autocomplete="off" name="numero" value="<?php echo $codigoCliente ?>" readonly="readonly"/>
                                                    </div> 
                                                    <div>
                                                        <label>Nome:</label></br>
                                                        <input class="input-nome" type="text" autocomplete="off" name="nome" value="<?php echo $nomeCliente ?>" readonly="readonly"/>    
                                                    </div>                                                     
                                                    <input class="input-botao" type="submit" name="adicionarCliente" value="Cliente"/>  
                                                </form>
                                            </div>

                                            <div class="form-cliente-caixa">
                                                <form class="form-pagamento" action='orcamento.processo.php' method='POST'>
                                                    <div>
                                                        <label>F. Pagamento</label></br>
                                                        <select class="input-pagamento" name="formaPagamento" onchange="this.form.submit()">
                                                            <option value=""><?php echo $formaPagamento?></option> 
                                                            <option value="Dinheiro">Dinheiro</option> 
                                                            <option value="Cartão">Cartão</option>
                                                            <option value="Cheque">Cheque</option>
                                                            <option value="Transferencia">Transferência</option>
                                                        </select>
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
                                                <form class="busca-area" name="buscar-form" method="POST" action="orcamento.produto.pesquisa.php">
                                                    <input type="submit" name="adicionarProduto" value="Incluir Produto">
                                                </form>   

                                                <form class="busca-area" name="buscar-form" method="POST" action="orcamento.processo.php">
                                                    <input type="submit" name="excluirLista" value="Excluir Lista">
                                                </form>

                                                <form class="busca-area" name="buscar-form" method="POST" action="orcamento.processo.php">
                                                    <?php 
                                                    if(isset($_SESSION['cliente'], $_SESSION['formaPagamento'], $_SESSION['orcamento'], $_SESSION['lista'])) {
                                                    ?>
                                                        <input type="submit" name="salvarLista" value="Salvar Lista">
                                                    <?php
                                                    } else {
                                                    }
                                                    ?>
                                                </form>
                                            </div>

                                            <div class="blocoNotas">
                                                <?php 

                                                if(isset($_SESSION['blocoNotas']['checkbox'])) {

                                                ?>

                                                <input type="checkbox" checked id="blocoNotas" name="blocoNotas" onclick="ativarBloco();">
                                                <label for="blocoNotas2">Bloco de Notas</label> 
                                                
                                                <?php                                                

                                                } else {
                                                ?>

                                                <input type="checkbox" id="blocoNotas" name="blocoNotas" onclick="ativarBloco();">
                                                <label for="blocoNotas2">Bloco de Notas</label>

                                                <?php
                                                
                                                }

                                                ?>
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
                                                <tr class="cabecalho" style="border:1px solid #000;">
                                                    <th>CÓDIGO</th>
                                                    <th>PRODUTO</th>
                                                    <th>EMB</th>
                                                    <th>QTD</th>
                                                    <th>PREÇO</th>
                                                    <th>TOTAL</th>                                                
                                                    <th>ESTOQUE</th>
                                                    <th>AÇÕES</th>                                                    
                                                </tr>

                                                <?php

                                                if(!empty($_SESSION['lista'])) {

                                                    foreach($_SESSION['lista'] as $key=>$value) {

                                                        $preco = $value['preco'];
                                                        $quantidade = $value['quantidade'];
                                                        $observacao = $value['observacao'];
                                                        $medida = $value['medida'];
                                                        $resultado = number_format($preco*$quantidade,2,",",".");

                                            

                                                        echo "<tr>";
                                                        echo "<td>".$value['codigoEan']."</td>";
                                                        echo "<td>".$value['produto']."</td>";
                                                        echo "<td>
                                                                    <form class='form-pagamento' action='orcamento.processo.php' method='GET'>
                                                                        <div>
                                                                            <input value=".$value['codigo']." class='quantidade' type='hidden' name='codigoProduto' required='required'>
                                                                            <select class='input-pagamento' name='medida' onchange='this.form.submit()'>
                                                                                <option value=''>".$medida."</option> 
                                                                                <option value='KG'>KG</option> 
                                                                                <option value='UN'>UN</option>
                                                                            </select>
                                                                        </div>
                                                                    </form>    
                                                                </td>"; 

                                                        echo "<td>
                                                                    <form class='' name='teste' method='GET' action='orcamento.processo.php'>      

                                                                        <input value=".$value['codigo']." class='quantidade' type='hidden' min='0'  name='codigoProduto' required='required'>
                                                                        <input value=".$quantidade." class='quantidade' type='number' min='0'  name='quantidade' required='required' onchange='this.form.submit()'>                                                        

                                                                    </form>     
                                                               </td>";                                                       
                                                        echo "<td>R$".number_format($preco,2,",",".")."</td>";
                                                        echo "<td>R$".$resultado."</td>";
                                                        echo "<td>".$value['estoque']."</td>"; 
                                                        echo '<td><a href="orcamento.processo.php?excluir='.$value['codigo'].'">Excluir</a>';
                                                        echo "</tr>";  
                                                    }
                                                }
                                                ?>                                        
                                            </table>
                                        </div>

                                        <div class="blocoNotasCorpo">
                                            <form class='' name='teste' method='POST' action='orcamento.processo.php'>                                            
                                                <textarea resize="none" value="" name="blocoNotas" onchange='this.form.submit()'><?php echo $bloco ?></textarea>
                                            </form>                                         
                                        </div>

                                    </div>   
                                </div> 

                            </div> 
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="assets/js/scriptcheckbox.js"></script> 

    </body>


</html>