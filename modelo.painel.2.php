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

if(isset($_SESSION['orcamento'])) {
    $orcamento = $_SESSION['orcamento'];
}

//=========================================SE REFERE AO CLIENTE========================================================================

if(isset($_SESSION['cliente'])) {
    $codigoCliente = $_SESSION['cliente']['id'];
    $nomeCliente = $_SESSION['cliente']['nome'];
}

//=========================================SE REFERE A FORMA DE PAGAMENTO========================================================================

if(isset($_SESSION['formaPagamento'])) {
    $formaPagamento = $_SESSION['formaPagamento'];
}

//===========================================SE REFERE AO TOTAL DOS PRODUTOS======================================================================

if(isset($_SESSION['lista'])) {

    foreach($_SESSION['lista'] as $key=>$value) {

        $soma = $value['preco'] * $value['quantidade'];

        $valorTotal += $soma;
    }

}

//=================================================================================================================


//var_dump($_SESSION);
//var_dump($valorGeral);


?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Pesquisa</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/modelo.css">
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
                                <a href="modelo.painel.1.php">Voltar</a>
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-busca">
                                    <div class="campo-inserir">

                                        <div class="formulario-cliente">    
                                                                      
                                            <form class="busca-area" name="buscar-form" method="POST" action="modelo.cliente.pesquisa.php">
                                                <div>
                                                    <label>Codigo:</label></br>
                                                    <input class="input5" type="number" min='0' autocomplete="off" name="numero" value="<?php echo $codigoCliente ?>" readonly="readonly"/>
                                                </div> 

                                                <div>
                                                    <label>Nome:</label></br>
                                                    <input class="input1" type="text" autocomplete="off" name="nome" placeholder="" value="<?php echo $nomeCliente ?>" readonly="readonly"/>    
                                                </div> 
                                                
                                                <input class="input-botao" type="submit" name="adicionarCliente" value="Cliente"/>  
                                            </form>

                                            <div>
                                                <form action='modelo.processo.php' method='POST'>
                                                    <label>F. Pagamento</label></br>
                                                    <select class="inputOrcamento" name="formaPagamento" onchange="this.form.submit()">
                                                        <option value=""><?php echo $formaPagamento?></option> 
                                                        <option value="Dinheiro">Dinheiro</option> 
                                                        <option value="Cartão">Cartão</option>
                                                        <option value="Cheque">Cheque</option>
                                                    </select>
                                                </form>
                                            </div>

                                            <div>
                                                <label>N. Orcamento</label></br>
                                                <input class="inputOrcamento" minlength="3" type="text" autocomplete="off" name="pesquisa" value="<?php echo $orcamento?>" readonly="readonly">
                                            </div>
                                            <div>
                                                <label>Valor Total</label></br>
                                                <input class="inputOrcamento" minlength="3" type="text" autocomplete="off" name="pesquisa" value='<?php echo "R$ ".number_format($valorTotal,2,",",".")?>' readonly="readonly">
                                            </div>

                                            
                                        </div>

                                        <hr>

                                        <div class="formulario-documento">      

                                            <form class="busca-area" name="buscar-form" method="POST" action="modelo.produto.pesquisa.php">
                                                 <input type="submit" name="adicionarProduto" value="Incluir Produto">
                                            </form>   

                                            <form class="busca-area" name="buscar-form" method="POST" action="modelo.processo.php">
                                                <input type="submit" name="excluirLista" value="Excluir Lista">
                                            </form>

                                            <form class="busca-area" name="buscar-form" method="POST" action="modelo.processo.php">
                                                <input type="submit" name="salvarLista" value="Salvar Lista">
                                            </form>

                                        </div>

                                            
                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:5%;">Codigo</th>
                                                <th style="width:40%;">Produto</th>
                                                <th style="width:10%;">Quantidade</th>
                                                <th style="width:10%;">Preco</th>
                                                <th style="width:10%;">Total</th>                                                
                                                <th style="width:10%;">Estoque</th>
                                                <th style="width:10%;">Observacoes</th>
                                                <th style="width:10%;">Acoes</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php

                                            

                                            if(!empty($_SESSION['lista'])) {


                                                foreach($_SESSION['lista'] as $key=>$value) {

                                                    $preco = $value['preco'];
                                                    $quantidade = $value['quantidade'];
                                                    $observacao = $value['observacao'];

                                                    $resultado = number_format($preco*$quantidade,2,",",".");

                                                    echo "<tr>";
                                                    echo "<td style='width:5%;'>".$value['codigo']."</td>";
                                                    echo "<td style='width:40%;'>".$value['produto']."</td>";


                                                    echo "<td style='width:10%;'>

                                                    <form class='' name='teste' method='GET' action='modelo.processo.php'>      

                                                        <input value=".$value['codigo']." class='quantidade' type='hidden' min='0'  name='produto' required='required'>
                                                        <input value=".$quantidade." class='quantidade' type='number' min='0'  name='quantidade' required='required' onchange='this.form.submit()'>                                                        

                                                    </form>     
                                                    </td>";
                                                    

                                                    
                                                    echo "<td style='width:10%;'>R$".number_format($preco,2,",",".")."</td>";
                                                    echo "<td style='width:10%;'>R$".$resultado."</td>";
                                                    echo "<td style='width:10%;'>".$value['estoque']."</td>"; 


                                                    echo "<td style='width:10%;'>

                                                    <form class='' name='teste' method='GET' action='modelo.processo.php'>      

                                                        <input value=".$value['codigo']." class='quantidade' type='hidden' min='0'  name='produto' required='required'>
                                                        <input value=".$observacao." class='quantidade' type='text' min='0'  name='observacao' onchange='this.form.submit()'>                                                        

                                                    </form>     
                                                    </td>";
                                                    
                                                    
                                                    echo '<td style="width:10%;"><a href="modelo.processo.php?excluir='.$value['codigo'].'">Excluir</a>';
                                                    echo "</tr>";  


  
                                                }
 
                                                
                                            } else {

                                                echo "</br>";
                                                echo "Lista não iniciada!";
                                               
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

        <!--<script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript" src="script2.js"></script>-->

    </body>


</html>