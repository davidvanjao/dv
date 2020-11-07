<?php

session_start();
require 'conexao.banco.php';
require 'classes/usuarios.class.php';
require 'modelo.processo.php';


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

//=================================================================================================================
if(isset($_GET['orcamento'])) {

    $numeroOrcamento = (int)$_GET['orcamento'];    

    if(!empty($numeroOrcamento)) {                

        $_SESSION['numeroOrcamento'][$numeroOrcamento] = array('orcamento'=>$numeroOrcamento);
        
    } else{

        die('Operacao de adicionar cliente deu errado!');
    } 

}

if(!empty($_SESSION['numeroOrcamento'])) {

    foreach($_SESSION['numeroOrcamento'] as $key=>$valueOrcamento) {

        $numeroOrc = $valueOrcamento['orcamento'];

    }
    
}


//=================================================================================================================

if(isset($_GET['id'])) {

    $idCliente = addslashes($_GET['id']);
    
    $sql = "SELECT a.id, a.idEndereco, a.nome, a.telefone, b.cidadeEstado, b.bairro, b.logradouro, a.numero 
    from tb_cliente a, tb_endereco b 
    where a.id = '$idCliente'
    and a.idEndereco = b.id";

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {        

        foreach($sql as $key => $valueCliente) {    

            if(isset($_SESSION['cliente'])) {   
                
                unset( $_SESSION['cliente'] );
                $_SESSION['cliente'][$idCliente] = array('idCliente'=>$valueCliente['id'], 'idEndereco'=>$valueCliente['idEndereco'], 'nomeCliente'=>$valueCliente['nome']);

            } else {

                $_SESSION['cliente'][$idCliente] = array('idCliente'=>$valueCliente['id'], 'idEndereco'=>$valueCliente['idEndereco'], 'nomeCliente'=>$valueCliente['nome']);           

            }
                      
        }   
                
    }      
    
}

if(!empty($_SESSION['cliente'])) {

    foreach($_SESSION['cliente'] as $key=>$valueCliente) {    
        
            $idCliente = $valueCliente['idCliente'];
            $nomeCliente = $valueCliente['nomeCliente'];            

    }

    
} 

//=================================================================================================================




var_dump($_SESSION);

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
                                                    <label>Id:</label></br>
                                                    <input class="input5" type="number" min='0' autocomplete="off" name="numero" value="<?php echo $idCliente ?>" readonly="readonly"/>
                                                </div> 

                                                <div>
                                                    <label>Nome:</label></br>
                                                    <input class="input1" type="text" autocomplete="off" name="nome" placeholder="" value="<?php echo $nomeCliente ?>" readonly="readonly"/>    
                                                </div> 
                                                
                                                <input class="input-botao" type="submit" name="botao-adicionar" value="Cliente"/>                                            

                                            </form>

                                            <div>
                                                <label>N. Orcamento</label></br>
                                                <input class="inputOrcamento" minlength="3" type="text" autocomplete="off" name="pesquisa" value="<?php echo $numeroOrc?>" readonly="readonly">                                            
                                            </div>
                                            
                                        </div>

                                        <div class="formulario-documento">      

                                            <form class="busca-area" name="buscar-form" method="POST" action="modelo.painel.pesquisa.php">
                                                 <input type="submit" name="botao-adicionar" value="Adicionar">
                                            </form>   

                                            <form class="busca-area" name="buscar-form" method="POST" action="modelo.painel.excluir.php">
                                                <input type="submit" name="limpar" value="Limpar">
                                            </form>

                                            <form class="busca-area" name="buscar-form" method="POST" action="">
                                                <input type="submit" name="botao-pesquisar" value="Salvar">
                                            </form>

                                        </div>


                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Codigo</th>
                                                <th style="width:50%;">Produto</th>
                                                <th style="width:10%;">Quantidade</th>
                                                <th style="width:10%;">Preco</th>
                                                <th style="width:10%;">Estoque</th>
                                                <th style="width:10%;">Acoes</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php

                                            

                                            if(!empty($_SESSION['orcamento'])) {


                                                foreach($_SESSION['orcamento'] as $key=>$value) {
                                                    echo "<tr>";
                                                    echo "<td style='width:10%;'>".$value['codigo']."</td>";
                                                    echo "<td style='width:50%;'>".$value['produto']."</td>";


                                                    echo "<td style='width:10%;'>

                                                    <form class='' name='buscar-form' method='POST'>
                                                    
                                                    <input value=".$value['quantidade']." class='quantidade' type='number' min='0'  name='quantProd' required='required' onchange='this.form.submit()'>

                                                    </form>     
                                                    </td>";
                                                    

                                                    
                                                    echo "<td style='width:10%;'>".$value['preco']."</td>";
                                                    echo "<td style='width:10%;'>".$value['estoque']."</td>";                                                    
                                                    echo '<td style="width:10%;"><a href="modelo.painel.excluir.php?excluir='.$value['id'].'">Excluir</a>';
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